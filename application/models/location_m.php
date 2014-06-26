<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Location_m extends MY_Model {

	public function get_event_metro_areas() {
		return $this->db	
			->select('ma.id, ma.city, count(v.Id) as count')
			->from('metroareas as ma')
			->join('venues as v', 'v.cityId  = ma.id', 'inner')
			->join('events as e', 'e.venueId = v.id AND e.datetime > CURDATE() + INTERVAL 1 DAY', 'inner')
			->group_by('ma.id')
			->order_by('ma.city')
			->get()
			->result();
	}

	public function get_all_metro_areas() {
		return $this->db
			->select('ma.*')
			->from('metroareas as ma')
			->order_by('ma.city')
			->get()
			->result();
	}
} 