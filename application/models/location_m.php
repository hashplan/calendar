<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Location_m extends MY_Model {

	public function get_cities() {
		return $this->db
			->select('c.id, c.city, COUNT(e.id) AS events_count')
			->from('events AS e')
			->join('venues AS v', 'e.venueId = v.id', 'inner')
			->join('cities AS c', 'v.cityId = c.id', 'inner')
			->order_by('c.city')
			->group_by('c.id')
			->get()
			->result();
	}
	
	public function get_metro_areas() {
		return $this->db	
			->select('ma.id, ma.city, count(v.Id) as count')
			->from('metroareas as ma')
			->join('venues as v', 'v.cityId  = ma.id')
			->group_by('ma.id, ma.city')
			->order_by('ma.city')
			->get()
			->result();
	}
} 