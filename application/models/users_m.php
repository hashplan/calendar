<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_m extends MY_Model {

	public function __construct() {
		$this->load->library('Ion_auth');
	}

	public function user_id_is_correct($user_id) {
		return is_numeric($user_id) && $user_id > 0;
	}

	public function is_admin_or_owner($user_id) {
		$is_admin = $this->ion_auth->in_group("admin");
		$is_owner = $user_id === $this->ion_auth->user()->row()->id;

		return $is_admin || $is_owner;
	}

	public function get_friends($options = array()) {
		$user_id = !empty($options['user_id']) && !$this->user_id_is_correct($options['user_id'])
			? $options['user_id']
			: $this->ion_auth->user()->row()->id;

		// CI active record doesnt support UNION
		// UNION is used to avoid full table scan
		$sql = "
			SELECT u.*
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
			ORDER BY u.first_name, u.last_name
		";

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


	public function get_mutual_friends($user_ids = array(), $friends_to_search_ids = array()) {
		if (empty($user_ids) || empty($friends_to_search_ids)) {
			return array();
		}

// array of "?" joined into smth like "?, ?, ?..."
		$placeholders_user_ids = join(',', array_fill(0, count($user_ids), '?'));
		$placeholders_friends_to_search_ids = join(',', array_fill(0, count($friends_to_search_ids), '?'));

		$query = $this->db->query('
			SELECT uc1.userId friend_id, uc1.connectionUserId friend_friend_id
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

	public function get_people_user_may_know($user_id = NULL, $friends_count = 2) {
		if (!$this->user_id_is_correct($user_id)) {
			$user_id = $this->ion_auth->user()->row()->id;;
		}

		$friends = $this->get_friends(array('user_id' => $user_id));
		$friends_ids = $placeholders = array();
		foreach ($friends as $friend) {
			$friends_ids[] = $friend->id;
			$placeholders[] = '?';
		}
		$placeholders = join(', ', $placeholders);

		$query = $this->db->query('
			SELECT t.user_id, COUNT(t.friend_id) friends_count, u.* /* 111111111111111111 */
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
			WHERE NOT EXISTS (SELECT 1 FROM user_connections uc3 WHERE uc3.userId = t.user_id AND uc3.connectionUserId = ? AND uc3.type = "removed")
			AND NOT EXISTS (SELECT 1 FROM user_connections uc4 WHERE uc4.userId = ? AND uc4.connectionUserId = t.user_id AND uc4.type = "removed")
			GROUP BY t.user_id
			HAVING COUNT(t.friend_id) >= ?
			ORDER BY friends_count DESC
			', array_merge($friends_ids, $friends_ids, $friends_ids, $friends_ids, array($user_id, $user_id, $friends_count))
		);

		return $query->result();
	}

// First name + last name OR username if both missing
	public function generate_full_name($user) {
		$name = $user->first_name .' '. $user->last_name;
		if (empty(trim($name))) {
			$name = $user->username;
		}

		return $name;
	}

	public function remove_from_lists($connection_user_id) {
		if (!$this->user_id_is_correct($connection_user_id)) {
			return;
		}

		$user_id = $this->ion_auth->user()->row()->id;
		if ($connection = $this->get_connection_between_users($user_id, $connection_user_id)) {
			$this->db
				->where('id', $connection->id)
				->update('user_connections', array('type' => 'removed'));
		}
		else {
			$this->db->insert('user_connections', array(
				'userId' => $user_id,
				'connectionUserId' => $connection_user_id,
				'type' => 'removed'
			));
		}

	}

	public function get_connection_between_users($user_id, $connection_user_id) {
		$sql = "
			SELECT uc1.*
			FROM user_connections uc1
			WHERE uc1.userId = ?
			AND uc1.connectionUserId = ?
			UNION
			SELECT uc2.*
			FROM user_connections uc2
			WHERE uc2.connectionUserId = ?
			AND uc2.userId = ?
		";

		return $this->db->query($sql, array($user_id, $connection_user_id, $connection_user_id, $user_id))->row();
	}

}