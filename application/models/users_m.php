<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_m extends MY_Model {

	public function user_id_is_correct($user_id) {
		return is_numeric($user_id) && $user_id > 0;
	}

	public function is_admin_or_owner($user_id) {
		$is_admin = $this->ion_auth->in_group("admin");
		$is_owner = $user_id === $this->ion_auth->user()->row()->id;

		return $is_admin || $is_owner;
	}

	public function get_friends($options = array()) {
		$user_id = !empty($options['user_id']) && $this->user_id_is_correct($options['user_id'])
			? $options['user_id']
			: $this->ion_auth->user()->row()->id;

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
			INNER JOIN user_settings us ON u.id = us.userId AND us.metroId IN ('. join(', ', $options['location_ids']) .')
			';
		}

		if (!empty($options['location_name'])) {
			$sql .= '
			INNER JOIN user_settings us ON u.id = us.userId
			INNER JOIN metroareas ma ON us.metroId = ma.id AND ma.city LIKE "%'. $this->db->escape_like_str($options['location_name']) .'%"
			';
		}

		$sql .= '
			ORDER BY u.first_name, u.last_name
		';

		$friends_raw = $this->db->query($sql, array($user_id, $user_id))->result();

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

	public function is_friend_of($friend_id = NULL) {
		if (!$this->user_id_is_correct($friend_id)) {
			return FALSE;
		}

		$is_friend = FALSE;
		foreach ($this->get_friends() as $friend) {
			if ($friend_id === $friend->id) {
				$is_friend = TRUE;
				break;
			}
		}

		return $is_friend;
	}

	public function get_connection_type_full_name($connection_type) {
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
				$name = 'Event Invite';
				break;
			default:
				$name = NULL;
		}

		return $name;
	}


	public function get_mutual_friends($user_ids = array(), $friends_to_search_ids = array()) {
		if (empty($user_ids) || empty($friends_to_search_ids)) {
			return array();
		}

// array of "?" joined into smth like "?, ?, ?..."
		$placeholders_user_ids = join(',', array_fill(0, count($user_ids), '?'));
		$placeholders_friends_to_search_ids = join(',', array_fill(0, count($friends_to_search_ids), '?'));

		$query = $this->db->query('
			SELECT uc1.userId friend_id, uc1.connectionUserId friend_friend_id /* get_mutual_friends */
			FROM user_connections uc1
			WHERE uc1.userId IN ('. $placeholders_user_ids .')
			AND uc1.connectionUserId IN ('. $placeholders_friends_to_search_ids .')
			AND uc1.type = "friend"
			UNION
			SELECT uc2.connectionUserId friend_id, uc2.userId friend_friend_id
			FROM user_connections uc2
			WHERE uc2.userId IN ('. $placeholders_friends_to_search_ids .')
			AND uc2.connectionUserId IN ('. $placeholders_user_ids .')
			AND uc2.type = "friend"
			ORDER BY friend_id
			', array_merge($user_ids, $friends_to_search_ids, $friends_to_search_ids, $user_ids)
		);

		return $query->result();
	}

	public function get_mutual_friends_count($user_ids = array(), $friends_to_search_ids = array()) {
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

	public function get_people_user_may_know($options = array()) {
		$user_id = !empty($options['user_id']) && $this->user_id_is_correct($options['user_id'])
			? $options['user_id']
			: $this->ion_auth->user()->row()->id;
		$friends_count = empty($options['friends_count']) ? 2 : $options['friends_count'];

		$friends = $this->get_friends(array('user_id' => $user_id));
		$friends_ids = $placeholders = array();
		foreach ($friends as $friend) {
			$friends_ids[] = $friend->id;
			$placeholders[] = '?';
		}
		$placeholders = join(', ', $placeholders);

		$user_metro = $this->db->from('user_settings')->where('userId', $user_id)->get();
		if ($user_metro->num_rows === 1) {}
		$user_metro_id = $user_metro->num_rows === 1 ? $user_metro->row()->metroId : 'NULL';
		if ($user_metro_id !== 'NULL') {
			$user_metro_id = $this->db->escape($user_metro_id);
		}

		$sql = '
			SELECT t.user_id, COUNT(t.friend_id) friends_count, u.*, IF( '. $user_metro_id .' IS NOT NULL AND '. $user_metro_id .' = us.metroId, 1, 2 ) metro_preference /* get_people_user_may_know */
			FROM
			(
				SELECT uc1.userId user_id, uc1.connectionUserId friend_id
				FROM user_connections uc1
				WHERE uc1.userId NOT IN ('. $placeholders .')
				AND uc1.connectionUserId IN ('. $placeholders .')
				AND uc1.type = "friend"
				UNION
				SELECT uc2.connectionUserId user_id, uc2.userId friend_id
				FROM user_connections uc2
				WHERE uc2.connectionUserId NOT IN ('. $placeholders .')
				AND uc2.userId IN ('. $placeholders .')
				AND uc2.type = "friend"
			) t
			INNER JOIN users u ON t.user_id = u.id
			INNER JOIN user_settings us ON u.id = us.userId
		';

		if (!empty($options['location_name'])) {
			$sql .= '
			INNER JOIN metroareas ma ON us.metroId = ma.id AND ma.city LIKE "%'. $this->db->escape_like_str($options['location_name']) .'%"
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
			AND us.metroId IN ('. join(', ', $options['location_ids']) .')
			';
		}

		$sql .= '
			AND u.id != ?
			GROUP BY t.user_id
			HAVING COUNT(t.friend_id) >= ?
			ORDER BY metro_preference, friends_count DESC
		';

		$people_raw = $this->db->query($sql, array_merge($friends_ids, $friends_ids, $friends_ids, $friends_ids, array($user_id, $user_id, $user_id, $friends_count))
		)->result();

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

		return $people;
	}

// First name + last name OR username if both missing
	public function generate_full_name($user) {
		$name = $user->first_name .' '. $user->last_name;
        $name = trim($name);
		if (empty($name)) {
			$name = $user->username;
		}

		return $name;
	}

	public function delete_connection_between_users($connection_user_id, $user_id = NULL) {
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

	public function set_connection_between_users($connection_user_id, $user_id = NULL, $type_to_search = NULL, $type_to_set = NULL, $event_id = NULL) {
		if (!$this->user_id_is_correct($connection_user_id)) {
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
			$this->db
				->where('id', $connection->id)
				->update('user_connections', array('type' => $type_to_set));
		}
		else {
			$values = array(
				'userId' => $user_id,
				'connectionUserId' => $connection_user_id,
				'type' => $type_to_set
			);
			$event_id_is_correct = $event_id !== NULL && is_numeric($event_id) && $event_id > 0;
			if ($event_id_is_correct) {
				$values['eventId'] = $event_id;
			}
			$this->db->insert('user_connections', $values);
		}
	}

	public function get_connection_between_users($user_id, $connection_user_id, $types = NULL, $event_id = NULL) {
		$types_clause1 = $types_clause2 = $event_id_clause1 = $event_id_clause2 = '';
		if (is_string($types)) {
			$types = array($types);
		}
		if (is_array($types) && count($types) > 0) {
			$type_placeholders = array_fill(0, count($types), '?');
			$types_clause1 .= ' AND uc1.type IN ('. join(', ', $type_placeholders) .') ';
			$types_clause2 .= ' AND uc2.type IN ('. join(', ', $type_placeholders) .') ';
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
			AND uc1.connectionUserId = ?".
			$types_clause1 .
			$event_id_clause1 ."
			UNION
			SELECT uc2.*
			FROM user_connections uc2
			WHERE uc2.connectionUserId = ?
			AND uc2.userId = ?".
			$types_clause2 .
			$event_id_clause2 ."
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

	public function get_users_which_sent_friend_request($options = array()) {
		$user_id = !empty($options['user_id']) && !$this->user_id_is_correct($options['user_id'])
			? $options['user_id']
			: $this->ion_auth->user()->row()->id;

		$users_raw = $this->db
			->select('u.*, uc.*, u.id AS id, uc.id AS user_connection_id /* get_users_which_sent_friend_request */')
			->from('user_connections AS uc')
			->join('users AS u', 'uc.userId = u.id', 'inner')
			->where('uc.type', 'friend_request')
			->where('uc.connectionUserId', $user_id)
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

	public function get_users_you_sent_friend_request($options = array()) {
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

	public function get_users_you_sent_event_invite($options = array()) {
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

	public function get_users_which_sent_event_invite($options = array()) {
		$user_id = !empty($options['user_id']) && !$this->user_id_is_correct($options['user_id'])
			? $options['user_id']
			: $this->ion_auth->user()->row()->id;

		$users_raw = $this->db
			->select('u.*, uc.*, u.id AS id, uc.id AS user_connection_id /* get_users_you_sent_event_invite */')
			->from('user_connections AS uc')
			->join('users AS u', 'uc.userId = u.id', 'inner')
			->where('uc.type', 'event_invite')
			->where('uc.eventid IS NOT NULL', NULL, FALSE)
			->where('uc.connectionUserId', $user_id)
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

	public function get_friends_you_can_invite_on_event($options = array()) {
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
			INNER JOIN users u ON uc.friend_id = u.id
				AND uc.type = 'friend'
		";

		if (!empty($options['exclude_ids'])) {
			foreach($options['exclude_ids'] as &$exclude_id) {
				$exclude_id = $this->db->escape($exclude_id);
			}
			$sql .= " AND u.id NOT IN (". join(', ', $options['exclude_ids']) .") ";
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
			ORDER BY u.first_name, u.last_name
		";

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
					$friends[] = $friend;
				}
				continue;
			}
			$friends[] = $friend;
		}

		return $friends;
	}

	public function save_user($user_data) {
		$is_new = empty($user_data['id']) && $this->user_id_is_correct($user_data['id']);
		if ($is_new) {

		}
		else {
			$user_id = $user_data['id'];
			unset($user_data['id']);

			if (empty($user_data['password']) && empty($user_data['password_confirm'])) {
				unset($user_data['password'], $user_data['password_confirm']);
			}
			else {
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

	public function get_user_metro($user_id = NULL) {
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

}