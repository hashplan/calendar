<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users_m extends MY_Model
{

    public function user_id_is_correct($user_id)
    {
        return is_numeric($user_id) && $user_id > 0;
    }

    public function is_admin_or_owner($user_id)
    {
        $is_admin = $this->ion_auth->in_group("admin");
        $is_owner = $user_id === $this->ion_auth->user()->row()->id;

        return $is_admin || $is_owner;
    }

    public function get_friends($options = array(), $get_all = false)
    {

        if (empty($options['limit'])) {
            $options['limit'] = 5;
        }

        if (empty($options['offset'])) {
            $options['offset'] = 0;
        }

        $user_id = !empty($options['user_id']) && $this->user_id_is_correct($options['user_id'])
            ? $options['user_id']
            : $this->ion_auth->user()->row()->id;

        $current_user = $this->ion_auth->user()->row()->id;

        // CI active record doesnt support UNION
        // UNION is used to avoid full table scan
        $sql = "
			SELECT u.* /* get_friends */
			FROM (
				SELECT uc1.connectionUserId friend_id, uc1.type
				FROM user_connections uc1
				WHERE uc1.userId = ?
				UNION
				SELECT uc2.userId friend_id, uc2.type
				FROM user_connections uc2
				WHERE uc2.connectionUserId = ?
			) uc
			INNER JOIN users u ON uc.friend_id = u.id AND uc.type = 'friend'
		";

        if (!empty($options['location_ids']) && $options['location_ids'][0] !== 'all' && empty($options['location_name'])) {
            foreach ($options['location_ids'] as &$location_id) {
                $location_id = $this->db->escape($location_id);
            }
            $sql .= '
			INNER JOIN user_settings us ON u.id = us.userId AND us.metroId IN (' . join(', ', $options['location_ids']) . ')
			';
        }

        if (!empty($options['location_name'])) {
            $sql .= '
			INNER JOIN user_settings us ON u.id = us.userId
			INNER JOIN metroareas ma ON us.metroId = ma.id AND ma.city LIKE "%' . $this->db->escape_like_str($options['location_name']) . '%"
			';
        }

        $sql .= '
			WHERE u.id != ?
		';

        if (isset($options['name']) && !empty($options['name'])) {
            $sql .= '
            AND (u.first_name LIKE "%' . $this->db->escape_like_str($options['name']) . '%" OR u.last_name LIKE "%' . $this->db->escape_like_str($options['name']) . '%")';
        }

        $sql .= '
			ORDER BY u.first_name, u.last_name
		';
        if (!$get_all) {
            $sql .= '
                LIMIT ?, ?
            ';
        }


        $friends_raw = $this->db->query($sql, array($user_id, $user_id, $current_user, $options['offset'], $options['limit']))->result();

        $friends = array();
        foreach ($friends_raw as $friend) {
            $friend->name = $this->generate_full_name($friend);
            if (!empty($options['name'])) {
                if (stripos($friend->name, $options['name']) !== FALSE) {
                    $friends[] = $friend;
                }
                continue;
            }
            $friends[] = $friend;
        }

        return $friends;
    }

    public function is_friend_of($friend_id = NULL)
    {
        if (!$this->user_id_is_correct($friend_id)) {
            return FALSE;
        }

        $is_friend = FALSE;
        foreach ($this->get_friends(array(), true) as $friend) {
            if ($friend_id === $friend->id) {
                $is_friend = TRUE;
                break;
            }
        }

        return $is_friend;
    }

    public function get_connection_type_full_name($connection_type)
    {
        switch ($connection_type) {
            case 'friend':
                $name = 'Friend';
                break;
            case 'removed':
                $name = 'Removed';
                break;
            case 'friend_request':
                $name = 'Friend Request';
                break;
            case 'event_invite':
                $name = 'Event Invite Pending';
                break;
            case 'event_invite_accept':
                $name = "Event Invite Accepted";
                break;
            default:
                $name = NULL;
        }

        return $name;
    }


    public function get_mutual_friends($user_ids = array(), $friends_to_search_ids = array())
    {
        if (empty($user_ids) || empty($friends_to_search_ids)) {
            return array();
        }

        // array of "?" joined into smth like "?, ?, ?..."
        $placeholders_user_ids = join(',', array_fill(0, count($user_ids), '?'));
        $placeholders_friends_to_search_ids = join(',', array_fill(0, count($friends_to_search_ids), '?'));

        $query = $this->db->query('
			SELECT uc1.userId friend_id, uc1.connectionUserId friend_friend_id /* get_mutual_friends */
			FROM user_connections uc1
			WHERE uc1.userId IN (' . $placeholders_user_ids . ')
			AND uc1.connectionUserId IN (' . $placeholders_friends_to_search_ids . ')
			AND uc1.type = "friend"
			UNION
			SELECT uc2.connectionUserId friend_id, uc2.userId friend_friend_id
			FROM user_connections uc2
			WHERE uc2.userId IN (' . $placeholders_friends_to_search_ids . ')
			AND uc2.connectionUserId IN (' . $placeholders_user_ids . ')
			AND uc2.type = "friend"
			ORDER BY friend_id
			', array_merge($user_ids, $friends_to_search_ids, $friends_to_search_ids, $user_ids)
        );

        return $query->result();
    }

    public function get_mutual_friends_count($user_ids = array(), $friends_to_search_ids = array())
    {
        if (empty($user_ids)) {
            return array();
        }

        $mutual_friends_raw = $this->get_mutual_friends($user_ids, $friends_to_search_ids);
        $mutual_friends_count = array();
        foreach ($mutual_friends_raw as $friend) {
            if (empty($mutual_friends_count[$friend->friend_id])) {
                $mutual_friends_count[$friend->friend_id] = 0;
            }
            $mutual_friends_count[$friend->friend_id] += 1;
        }

        return $mutual_friends_count;
    }

    public function get_people_user_may_know($options = array())
    {

        $people = array();
        $user_id = !empty($options['user_id']) && $this->user_id_is_correct($options['user_id'])
            ? $options['user_id']
            : $this->ion_auth->user()->row()->id;
        $friends = $this->get_friends(array('user_id' => $user_id), true);

        if (!empty($friends)) {
            $friends_count = empty($options['friends_count']) ? 2 : $options['friends_count'];
            $friends_ids = $placeholders = array();
            foreach ($friends as $friend) {
                $friends_ids[] = $friend->id;
                $placeholders[] = '?';
            }

            $placeholders = join(', ', $placeholders);

            $user_metro = $this->db->from('user_settings')->where('userId', $user_id)->get();
            if ($user_metro->num_rows === 1) {
            }
            $user_metro_id = $user_metro->num_rows === 1 ? $user_metro->row()->metroId : 'NULL';
            if ($user_metro_id !== 'NULL') {
                $user_metro_id = $this->db->escape($user_metro_id);
            }

            $sql = '
			    SELECT t.user_id, COUNT(t.friend_id) friends_count, u.*, IF( ' . $user_metro_id . ' IS NOT NULL AND ' . $user_metro_id . ' = us.metroId, 1, 2 ) metro_preference /* get_people_user_may_know */
                FROM
                (
                    SELECT uc1.userId user_id, uc1.connectionUserId friend_id
                    FROM user_connections uc1
                    WHERE uc1.userId NOT IN (' . $placeholders . ')
                    AND uc1.connectionUserId IN (' . $placeholders . ')
                    AND uc1.type = "friend"
                    UNION
                    SELECT uc2.connectionUserId user_id, uc2.userId friend_id
                    FROM user_connections uc2
                    WHERE uc2.connectionUserId NOT IN (' . $placeholders . ')
                    AND uc2.userId IN (' . $placeholders . ')
                    AND uc2.type = "friend"
                ) t
                INNER JOIN users u ON t.user_id = u.id
                INNER JOIN user_settings us ON u.id = us.userId
            ';

            if (!empty($options['location_name'])) {
                $sql .= '
			INNER JOIN metroareas ma ON us.metroId = ma.id AND ma.city LIKE "%' . $this->db->escape_like_str($options['location_name']) . '%"
			';
            }

            $sql .= '
                WHERE NOT EXISTS (SELECT 1 FROM user_connections uc3 WHERE uc3.userId = t.user_id AND uc3.connectionUserId = ? AND uc3.type IN ("removed", "friend_request"))
                AND NOT EXISTS (SELECT 1 FROM user_connections uc4 WHERE uc4.userId = ? AND uc4.connectionUserId = t.user_id AND uc4.type IN ("removed", "friend_request"))
            ';

            if (!empty($options['location_ids']) && $options['location_ids'][0] !== 'all' && empty($options['location_name'])) {
                foreach ($options['location_ids'] as &$location_id) {
                    $location_id = $this->db->escape($location_id);
                }
                $sql .= '
			AND us.metroId IN (' . join(', ', $options['location_ids']) . ')
			';
            }

            $sql .= '
                AND u.id != ?
                GROUP BY t.user_id
                HAVING COUNT(t.friend_id) >= ?
                ORDER BY metro_preference, friends_count DESC
            ';

            $people_raw = $this->db->query($sql, array_merge($friends_ids, $friends_ids, $friends_ids, $friends_ids, array($user_id, $user_id, $user_id, $friends_count)))->result();

            $people = array();
            foreach ($people_raw as $dude) {
                $dude->name = $this->generate_full_name($dude);
                if (!empty($options['name'])) {
                    if (stripos($dude->name, $options['name']) !== FALSE) {
                        $people[] = $dude;
                    }
                    continue;
                }
                $people[] = $dude;
            }
        } else {
            //maybe we should show random users from the same location
        }

        return $people;
    }

    // First name + last name OR username if both missing
    public function generate_full_name($user)
    {
        $name = $user->first_name . ' ' . $user->last_name;
        $name = trim($name);
        if (empty($name)) {
            $name = $user->username;
        }

        return $name;
    }

    public function delete_connection_between_users($connection_user_id, $user_id = NULL)
    {
        if (!$this->user_id_is_correct($connection_user_id)) {
            return;
        }
        $user_id = $this->user_id_is_correct($user_id) ? $user_id : $this->ion_auth->user()->row()->id;

        $this->db
            ->where('connectionUserId', $connection_user_id)
            ->where('userId', $user_id)
            ->delete('user_connections');

        $this->db
            ->where('userId', $connection_user_id)
            ->where('connectionUserId', $user_id)
            ->delete('user_connections');
    }

    public function refused_event_invite($event_id)
    {
        return $this->db->delete('user_connections',
            array('eventId' => $event_id,
                'connectionUserId' => $this->ion_auth->user()->row()->id,
                'type' => 'event_invite'));
    }

    public function accept_event_invite($event_id)
    {
        return $this->db->update('user_connections',
            array('type' => 'event_invite_accept'),
            array('eventId' => $event_id,
                'connectionUserId' => $this->ion_auth->user()->row()->id,
                'type' => 'event_invite'));
    }

    public function get_invites_by_event_id($eventId, $userId = null)
    {
        if (is_null($userId)) {
            $userId = $this->ion_auth->user()->row()->id;
        }
        $where = array(
            'eventId' => $eventId,
            'connectionUserId' => $userId
        );
        return $this->db
            ->join('users', 'users.id = user_connections.userId', 'INNER')
            ->where($where)
            ->get('user_connections')
            ->result();
    }

    public function set_connection_between_users($connection_user_id, $user_id = NULL, $type_to_search = NULL, $type_to_set = NULL, $event_id = NULL)
    {
        if (!$this->user_id_is_correct($connection_user_id) && !$event_id) {
            return;
        }

        $type_is_correct = $type_to_set !== NULL;
        if (!$type_is_correct) {
            return;
        }

        $user_id = $this->user_id_is_correct($user_id) ? $user_id : $this->ion_auth->user()->row()->id;

        $connections = $this->get_connection_between_users($user_id, $connection_user_id, $type_to_search, $event_id);
        if (!empty($connections)) {
            $connection = reset($connections);
            $result = $this->db
                ->where('id', $connection->id)
                ->update('user_connections', array('type' => $type_to_set));
        } else {
            $values = array(
                'userId' => $user_id,
                'connectionUserId' => $connection_user_id,
                'type' => $type_to_set
            );
            $event_id_is_correct = $event_id !== NULL && is_numeric($event_id) && $event_id > 0;
            if ($event_id_is_correct) {
                $values['eventId'] = $event_id;
            }
            $result = $this->db->insert('user_connections', $values);
        }
        return $result;
    }

    public function get_connection_between_users($user_id, $connection_user_id, $types = NULL, $event_id = NULL)
    {
        $types_clause1 = $types_clause2 = $event_id_clause1 = $event_id_clause2 = '';
        if (is_string($types)) {
            $types = array($types);
        }
        if (is_array($types) && count($types) > 0) {
            $type_placeholders = array_fill(0, count($types), '?');
            $types_clause1 .= ' AND uc1.type IN (' . join(', ', $type_placeholders) . ') ';
            $types_clause2 .= ' AND uc2.type IN (' . join(', ', $type_placeholders) . ') ';
        }
        $event_id_is_correct = $event_id !== NULL && is_numeric($event_id) && $event_id > 0;
        if ($event_id_is_correct) {
            $event_id_clause1 = ' AND uc1.eventId = ? ';
            $event_id_clause2 = ' AND uc2.eventId = ? ';
        }

        $sql = "
			SELECT uc1.* /* get_connection_between_users */
			FROM user_connections uc1
			WHERE uc1.userId = ?
			AND uc1.connectionUserId = ?" .
            $types_clause1 .
            $event_id_clause1 . "
			UNION
			SELECT uc2.*
			FROM user_connections uc2
			WHERE uc2.connectionUserId = ?
			AND uc2.userId = ?" .
            $types_clause2 .
            $event_id_clause2 . "
		";

        $parameters = array();
        $parameters[] = $user_id;
        $parameters[] = $connection_user_id;
        if (is_array($types) && count($types) > 0) {
            $parameters = array_merge($parameters, $types);
        }
        if ($event_id_is_correct) {
            $parameters[] = $event_id;
        }
        $parameters[] = $user_id;
        $parameters[] = $connection_user_id;
        if (is_array($types) && count($types) > 0) {
            $parameters = array_merge($parameters, $types);
        }
        if ($event_id_is_correct) {
            $parameters[] = $event_id;
        }

        return $this->db->query($sql, $parameters)->result();
    }

    public function get_users_which_sent_friend_request($options = array())
    {
        $user_id = !empty($options['user_id']) && !$this->user_id_is_correct($options['user_id']) ? $options['user_id']
            : $this->ion_auth->user()->row()->id;

        $this->db
            ->select('u.*, uc.*, u.id AS id, uc.id AS user_connection_id /* get_users_which_sent_friend_request */')
            ->from('user_connections AS uc')
            ->join('users AS u', 'uc.userId = u.id', 'inner')
            ->where('uc.type', 'friend_request')
            ->where('uc.connectionUserId', $user_id)
            ->order_by('first_name')
            ->order_by('last_name');

        if (empty($options['limit'])) {
            $options['limit'] = 5;
        }

        if (empty($options['offset'])) {
            $options['offset'] = 0;
        }
        $users_raw = $this->db
            /*->limit($options['limit'], $options['offset'])*/
            ->get()
            ->result();

        $users = array();
        foreach ($users_raw as $user) {
            $user->name = $this->generate_full_name($user);
            if (!empty($options['name'])) {
                if (stripos($user->name, $options['name']) !== FALSE) {
                    $users[] = $user;
                }
                continue;
            }
            $user->connection_type_full = $this->get_connection_type_full_name($user->type);
            $users[] = $user;
        }

        return $users;
    }

    public function get_users_you_sent_friend_request($options = array())
    {
        $user_id = !empty($options['user_id']) && !$this->user_id_is_correct($options['user_id'])
            ? $options['user_id']
            : $this->ion_auth->user()->row()->id;

        $users_raw = $this->db
            ->select('u.*, uc.*, u.id AS id, uc.id AS user_connection_id /* get_users_you_sent_friend_request */')
            ->from('user_connections AS uc')
            ->join('users AS u', 'uc.connectionUserId = u.id', 'inner')
            ->where('uc.type', 'friend_request')
            ->where('uc.userId', $user_id)
            ->order_by('first_name')
            ->order_by('last_name')
            ->get()
            ->result();

        $users = array();
        foreach ($users_raw as $user) {
            $user->name = $this->generate_full_name($user);
            if (!empty($options['name'])) {
                if (stripos($user->name, $options['name']) !== FALSE) {
                    $users[] = $user;
                }
                continue;
            }
            $user->connection_type_full = $this->get_connection_type_full_name($user->type);
            $users[] = $user;
        }

        return $users;
    }

    public function get_users_you_sent_event_invite($options = array())
    {
        $user_id = !empty($options['user_id']) && !$this->user_id_is_correct($options['user_id'])
            ? $options['user_id']
            : $this->ion_auth->user()->row()->id;

        $users_raw = $this->db
            ->select('u.*, uc.*, u.id AS id, uc.id AS user_connection_id /* get_users_you_sent_event_invite */')
            ->from('user_connections AS uc')
            ->join('users AS u', 'uc.connectionUserId = u.id', 'inner')
            ->where('uc.type', 'event_invite')
            ->where('uc.eventid IS NOT NULL', NULL, FALSE)
            ->where('uc.userId', $user_id)
            ->order_by('first_name')
            ->order_by('last_name')
            ->get()
            ->result();

        $users = array();
        foreach ($users_raw as $user) {
            $user->name = $this->generate_full_name($user);
            if (!empty($options['name'])) {
                if (stripos($user->name, $options['name']) !== FALSE) {
                    $users[] = $user;
                }
                continue;
            }
            $user->connection_type_full = $this->get_connection_type_full_name($user->type);
            $users[] = $user;
        }

        return $users;
    }

    public function get_users_which_sent_event_invite($options = array())
    {
        $user_id = !empty($options['user_id']) && !$this->user_id_is_correct($options['user_id'])
            ? $options['user_id']
            : $this->ion_auth->user()->row()->id;

        $events_raw = $this->db
            ->select('uc.type as type, u.id as uid, u.first_name as first_name, u.last_name as last_name, u.avatar_path as avatar_path')
            ->select('e.id as event_id, e.name as event_name, v.name as venue_name, e.datetime as datetime')
            ->from('user_connections AS uc')
            ->join('users AS u', 'uc.userId = u.id', 'inner')
            ->join('events AS e', 'uc.eventId = e.id', 'inner')
            ->join('venues AS v', 'v.id = e.venueId', 'inner')
            ->where('uc.type', 'event_invite')
            ->where('uc.eventId IS NOT NULL', NULL, FALSE)
            ->where('uc.connectionUserId', $user_id)
            ->order_by('u.first_name')
            ->order_by('u.last_name')
            ->get()
            ->result();

        $events = array();
        if (!empty($events_raw)) {
            foreach ($events_raw as $event) {
                $event->user_name = $this->generate_full_name($event);
                if (!empty($options['name']) && stripos($event->user_name, $options['name']) == FALSE) {
                    continue;
                }
                $events[$event->event_id]['users'][$event->uid] = array(
                    'uid' => $event->uid,
                    'user_name' => $event->user_name,
                    'avatar_path' => $event->avatar_path
                );
                $events[$event->event_id]['event_id'] = $event->event_id;
                $events[$event->event_id]['event_name'] = $event->event_name;
                $events[$event->event_id]['vanue_name'] = $event->venue_name;
                $events[$event->event_id]['datetime'] = $event->datetime;
            }
        }

        return $events;
    }

    public function get_friends_you_can_invite_on_event($options = array())
    {
        $user_id = !empty($options['user_id']) && !$this->user_id_is_correct($options['user_id'])
            ? $options['user_id']
            : $this->ion_auth->user()->row()->id;

        $event_id_is_correct = $options['event_id'] !== NULL && is_numeric($options['event_id']) && $options['event_id'] > 0;
        if (!$event_id_is_correct) {
            return array();
        }

        $sql = "
			SELECT u.* /* get_friends_you_can_invite_on_event */
				,ue.eventId IS NOT NULL will_visit
				,ue.eventId IS NULL AND uc3.userId IS NOT NULL is_inviter
				,ue.eventId IS NULL AND uc4.connectionUserId IS NOT NULL is_invitee
			FROM (
				SELECT uc1.connectionUserId friend_id, uc1.type
				FROM user_connections uc1
				WHERE uc1.userId = ?
				UNION
				SELECT uc2.userId friend_id, uc2.type
				FROM user_connections uc2
				WHERE uc2.connectionUserId = ?
			) uc
			INNER JOIN users u ON uc.friend_id = u.id AND uc.type = 'friend'
		";

        if (!empty($options['exclude_ids'])) {
            foreach ($options['exclude_ids'] as &$exclude_id) {
                $exclude_id = $this->db->escape($exclude_id);
            }
            $sql .= " AND u.id NOT IN (" . join(', ', $options['exclude_ids']) . ") ";
        }

        $sql .= "
			LEFT JOIN user_events ue ON u.id = ue.userId
				AND ue.eventId = ?
			LEFT JOIN user_connections uc3 ON u.id = uc3.userId
                AND uc3.type = 'event_invite'
                AND uc3.connectionUserId = ?
                AND uc3.eventId = ?
			LEFT JOIN user_connections uc4 ON u.id = uc4.connectionUserId
                AND uc4.type = 'event_invite'
                AND uc4.userId = ?
                AND uc4.eventId = ?
		";
        if (isset($options['name']) && !empty($options['name'])) {
            $sql .= '
                WHERE u.first_name LIKE "%' . $this->db->escape_like_str($options['name']) . '%"
                OR u.last_name LIKE "%' . $this->db->escape_like_str($options['name']) . '%"
            ';
        }
        $sql .= '
            ORDER BY u.first_name, u.last_name
        ';

        $params = array($user_id, $user_id, $options['event_id'], $user_id, $options['event_id'], $user_id, $options['event_id']);

        if (!empty($options['limit'])) {
            $sql .= " LIMIT ? ";
            $params[] = $options['limit'];
        }
        $friends_raw = $this->db->query($sql, $params)->result();

        $friends = array();
        foreach ($friends_raw as $friend) {
            $friend->name = $this->generate_full_name($friend);
            if (!empty($options['name'])) {
                if (stripos($friend->name, $options['name']) !== FALSE) {
                    $friends[$friend->id]['id'] = $friend->id;
                    $friends[$friend->id]['name'] = $friend->name;
                    $friends[$friend->id]['avatar_path'] = $friend->avatar_path;
                }
                continue;
            }
            $friends[] = $friend;
        }

        return $friends;
    }

    public function get_friends_related_with_event($event_id = null)
    {

        $result = array();
        if (!is_null($event_id)) {
            $user_id = $user = $this->ion_auth->user()->row()->id;
            $event_id_is_correct = $event_id !== NULL && is_numeric($event_id) && $event_id > 0;
            if ($event_id_is_correct) {
                $sql = "
                SELECT uc.eventId, uc.type, u.*, uc.invited
                FROM (
                    SELECT uc1.connectionUserId friend_id, uc1.type, uc1.eventId, uc1.connectionUserId as invited
                    FROM user_connections uc1
                    WHERE uc1.userId = ?
                    UNION
                    SELECT uc2.userId friend_id, uc2.type, uc2.eventId, uc2.connectionUserId as invited
                    FROM user_connections uc2
                    WHERE uc2.connectionUserId = ?
                ) uc
                INNER JOIN users u ON uc.friend_id = u.id AND u.active = 1
                WHERE uc.type IN ('event_invite', 'event_invite_accept') AND uc.eventId = ?
                UNION ALL
                SELECT uc.eventId, uc.type, u.*, uc.invited
                FROM (
                    SELECT uc1.connectionUserId friend_id, uc1.type, uc1.eventId, uc1.connectionUserId as invited
                    FROM user_connections uc1
                    WHERE uc1.userId = ?
                    UNION
                    SELECT uc2.userId friend_id, uc2.type, uc2.eventId, uc2.connectionUserId as invited
                    FROM user_connections uc2
                    WHERE uc2.connectionUserId = ?
                ) uc
                INNER JOIN users u ON uc.friend_id = u.id AND u.active = 1
                INNER JOIN user_events ue
                WHERE uc.type = 'friend' AND ue.userId = uc.friend_id AND ue.eventId = ?
                ORDER BY last_name, first_name;
            ";
                $params = array($user_id, $user_id, $event_id, $user_id, $user_id, $event_id);
                $result_raw = $this->db->query($sql, $params)->result();
                if (!empty($result_raw)) {
                    foreach ($result_raw as $row) {
                        $result[$row->id]['id'] = $row->id;
                        $result[$row->id]['name'] = $this->generate_full_name($row);
                        $result[$row->id]['type'] = $row->type;
                        $result[$row->id]['invited'] = $row->invited;
                        $result[$row->id]['avatar_path'] = $row->avatar_path;
                    }
                } else {
                    $result = $result_raw;
                }
            }
        }

        return $result;
    }

    public function save_user($user_data)
    {
        $is_new = empty($user_data['id']) && $this->user_id_is_correct($user_data['id']);
        if ($is_new) {

        } else {
            $user_id = $user_data['id'];
            unset($user_data['id']);

            if (empty($user_data['password']) && empty($user_data['password_confirm'])) {
                unset($user_data['password'], $user_data['password_confirm']);
            } else {
                $user = $this->ion_auth->user()->row();
                $user_data['password'] = $this->ion_auth->hash_password($user_data['password'], $user->salt);
                unset($user_data['password_confirm']);
            }

            if (!empty($user_data['metro_id'])) {
                $this->db
                    ->where('userId', $user_id)
                    ->update('user_settings', array('metroId' => $user_data['metro_id']));
            }
            unset($user_data['metro_id']);

            $this->db
                ->where('id', $user_id)
                ->update('users', $user_data);
        }

        return $this->db->affected_rows() === 1;
    }

    public function get_user_metro($user_id = NULL)
    {
        if (!$this->user_id_is_correct($user_id)) {
            return NULL;
        }

        return $this->db
            ->from('user_settings AS us')
            ->join('metroareas AS ma', 'ma.id = us.metroId')
            ->where('userId', $user_id)
            ->get()
            ->row();
    }

    public function get_unknown_users($options = array(), $get_all = false)
    {

        $result = array();

        if (!isset($options['limit']) || empty($options['limit'])) {
            $options['limit'] = 5;
        }

        if (!isset($options['offset']) || empty($options['offset'])) {
            $options['offset'] = 0;
        }

        $user_id = $this->ion_auth->user()->row()->id;

        if (isset($options['location_ids']) && !empty($options['location_ids']) && $options['location_ids'][0] !== 'all' && empty($options['location_name'])) {
            $location_ids = array();
            foreach ($options['location_ids'] as &$location_id) {
                $location_ids[] = (int)$location_id;
            }
            $this->db->join('user_settings us', 'u.id = us.userId', 'INNER');
            $this->db->where_in('us.metroId', $location_ids);

        }

        if (isset($options['location_name']) && !empty($options['location_name'])) {
            $this->db->join('user_settings us', 'u.id = us.userId', 'INNER');
            $this->db->join('metroareas ma', 'us.metroId = ma.id', 'INNER');
            $this->db->like('ma.city', $options['location_name']);
        }

        if (isset($options['name']) && !empty($options['name'])) {
            $this->db->where('(u.first_name LIKE "%' . $this->db->escape_like_str($options['name']) . '%" OR u.last_name LIKE "%' . $this->db->escape_like_str($options['name']) . '%")');
        }

        $this->db
            ->select('u.id, u.username, u.first_name, u.last_name')
            ->from('users AS u')
            ->where('NOT EXISTS (SELECT 1 FROM user_connections uc WHERE (u.id = uc.userId AND uc.connectionUserId = ' . $user_id . ') OR (u.id=uc.connectionUserId AND uc.userId = ' . $user_id . '))', '', FALSE)
            ->where(array('u.id !=' => $user_id, 'u.active' => 1))
            ->order_by('u.first_name ASC, u.last_name ASC');
        if (!$get_all) {
            $this->db->limit($options['limit'], $options['offset']);
        }
        $query = $this->db->get();

        if ($query->num_rows > 0) {
            foreach ($query->result() as $row) {
                $row->name = $this->generate_full_name($row);
                $result[] = $row;
            }
        }

        return $result;
    }

    public function get_all_friends_ids_string()
    {
        $user_id = $this->ion_auth->user()->row()->id;
        $result = '';
        $sql = "
			SELECT GROUP_CONCAT(uc.friend_id) ids
			FROM (
				SELECT uc1.connectionUserId friend_id, uc1.type
				FROM user_connections uc1
				WHERE uc1.userId = ?
				UNION
				SELECT uc2.userId friend_id, uc2.type
				FROM user_connections uc2
				WHERE uc2.connectionUserId = ?
			) uc
			WHERE uc.type = 'friend'
		";
        $query = $this->db->query($sql, array($user_id, $user_id));
        if ($query->num_rows > 0) {
            $result = $query->row()->ids;
        }

        return $result;
    }

    public function get_common_friends_with($options = array(), $get_all = false)
    {
        $result = array();

        if (isset($options['user_id'])) {

            $current_user_id = $this->ion_auth->user()->row()->id;
            $params = array(
                $options['user_id'], $options['user_id'], $options['user_id'], $current_user_id, $current_user_id,
                $current_user_id, $current_user_id, $current_user_id, $options['user_id'], $options['user_id']
            );

            if (empty($options['limit'])) {
                $options['limit'] = 5;
            }

            if (empty($options['offset'])) {
                $options['offset'] = 0;
            }

            $sql = "
                SELECT u.id as id, u.first_name as first_name, u.last_name as last_name, u.avatar_path as avatar_path
                FROM (SELECT CASE WHEN uc.userId = ? THEN uc.connectionUserId ELSE uc.userId END as friendId
                FROM user_connections uc
                WHERE uc.type = 'friend' AND (uc.userId=? OR uc.connectionUserId=?) AND uc.userId != ? AND uc.connectionUserId != ?) a
                JOIN (SELECT CASE WHEN uc.userId = ? THEN uc.connectionUserId ELSE uc.userId END as friendId
                      FROM user_connections uc
                      WHERE uc.type = 'friend' AND (uc.userId=? OR uc.connectionUserId=?) AND uc.userId != ? AND uc.connectionUserId != ?) b
                ON a.friendId = b.friendId
                INNER JOIN users u ON u.id = a.friendId
            ";

            if (!empty($options['location_ids']) && $options['location_ids'][0] !== 'all' && empty($options['location_name'])) {
                foreach ($options['location_ids'] as &$location_id) {
                    $location_id = $this->db->escape($location_id);
                }
                $sql .= '
			    INNER JOIN user_settings us ON u.id = us.userId AND us.metroId IN (' . join(', ', $options['location_ids']) . ')
			';
            }

            if (!empty($options['location_name'])) {
                $sql .= '
                INNER JOIN user_settings us ON u.id = us.userId
                INNER JOIN metroareas ma ON us.metroId = ma.id AND ma.city LIKE "%' . $this->db->escape_like_str($options['location_name']) . '%"
			';
            }
            if (isset($options['name']) && !empty($options['name'])) {
                $sql .= '
            AND (u.first_name LIKE "%' . $this->db->escape_like_str($options['name']) . '%" OR u.last_name LIKE "%' . $this->db->escape_like_str($options['name']) . '%")';
            }

            $sql .= '
                ORDER BY u.first_name, u.last_name
            ';
            if (!$get_all) {
                $sql .= '
                    LIMIT ?, ?
                ';
                $params[] = isset($options['offset']) ? $options['offset'] : 0;
                $params[] = isset($options['limit']) ? $options['limit'] : 0;

            }

            $friends_raw = $this->db->query($sql, $params)->result();
            foreach ($friends_raw as $friend) {
                $friend->name = $this->generate_full_name($friend);
                if (!empty($options['name'])) {
                    if (stripos($friend->name, $options['name']) !== FALSE) {
                        $result[] = $friend;
                    }
                    continue;
                }
                $result[] = $friend;
            }
        }

        return $result;
    }
}