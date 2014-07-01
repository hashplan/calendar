<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Location_m extends MY_Model {

	public function get_event_metro_areas() {
		return $this->db
			->select('ma.id, ma.city, count(v.Id) as count /* get_event_metro_areas() */', FALSE)
			->from('metroareas as ma')
			->join('venues as v', 'v.cityId  = ma.id', 'inner')
			->join('events as e', 'e.venueId = v.id AND e.datetime > CURDATE() + INTERVAL 1 DAY', 'inner')
			->group_by('ma.id')
			->order_by('ma.city')
			->get()
			->result();
	}

	public function get_all_metro_areas() {
		$post = $this->input->post();
		$options['name'] = (!empty($post['name'])) ? $post['name'] : NULL;
		if ($options['name'] !== NULL) {
			$this->db->like('city', $options['name']);
		}

		$this->db
			->select('ma.* /* get_all_metro_areas() */', FALSE)
			->from('metroareas as ma')
			->order_by('ma.city');

		return $this->db
			->get()
			->result();
	}

	public function get_metro_areas_with_user_filter($users) {
		$this->load->model('users_m');
		$user_ids = array();
		foreach ($users as $user) {
			$user_id = is_object($user) ? $user->id : $user['id'];
			if (!$this->users_m->user_id_is_correct($user_id)) {
				continue;
			}
			$user_ids[] = $this->db->escape($user_id);
		}

		return $this->db
			->distinct()
			->select('ma.* /* get_metro_areas_with_user_filter() */', FALSE)
			->from('metroareas as ma')
			->join('user_settings as us', 'ma.id = us.metroId AND us.userId IN ('. join(', ', $user_ids) .')')
			->order_by('ma.city')
			->get()
			->result();
	}
} 