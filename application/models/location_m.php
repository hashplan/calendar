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

} 