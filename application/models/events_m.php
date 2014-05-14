<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events_m extends MY_Model {

	public function get_all($offset = 0, $limit = 5, $name = NULL, $city_id = NULL, $user_id = NULL){
		$this->db
			->select('e.id AS eventId, e.name, e.datetime')
			->from('events AS e')
			->join('venues AS v', 'e.venueId = v.id', 'inner')
			->order_by('e.datetime')
			->limit($limit, $offset);

		if ($name) {
			$this->db->like('e.name', $name);
		}

		if ($city_id) {
			$this->db->where('v.cityId', $city_id);
		}

		if ($user_id !== NULL) {
			$this->db->join('user_events AS ue', 'e.id = ue.eventId AND ue.deleted = 0 AND ue.userId = '. $this->db->escape($user_id));
		}

		return $this->db->get()->result();
	}
}