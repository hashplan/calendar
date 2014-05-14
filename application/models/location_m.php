<?php

class Location_m extends MY_Model {

	public function get_cities() {
		return $this->db
			->distinct()
			->select('ma.id, ma.city')
			->from('metroareas AS ma')
			->join('venues v', 'ma.id = v.cityId', 'inner')
			->join('events e', 'v.id = e.venueId', 'inner')
			->order_by('ma.stateId')
			->get()
			->result();
	}

} 