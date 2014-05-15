<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events_m extends MY_Model {

	public function get_all($options = array()){
		// $offset = 0, $limit = 5, $name = NULL, $city_id = NULL, $user_id = NULL
		if (empty($options['limit'])) {
			$options['limit'] = 5;
		}

		if (empty($options['offset'])) {
			$options['offset'] = 0;
		}

		$this->db
			->select('e.eventId, e.name, e.datetime')
			->from('events AS e')
			->join('venues AS v', 'e.venueId = v.id', 'inner')
			->order_by('e.datetime')
			->limit($options['limit'], $options['offset']);

		if (!empty($options['name'])) {
			$this->db->like('e.name', $options['name']);
		}

		if (!empty($options['city_id'])) {
			$this->db->where('v.cityId', $options['city_id']);
		}

		if (!empty($options['user_id'])) {
			$this->db->join('user_events AS ue', 'e.id = ue.eventId AND ue.deleted = 0 AND ue.userId = '. $this->db->escape($options['user_id']));
		}

		if (!empty($options['preselects'])) {
			$date_range = array();
			if ($options['preselects'] == 'weekend') {
				$date_range['start'] = date('Y-m-d H:i:s', strtotime('next Saturday'));
				$date_range['end'] = date('Y-m-d H:i:s', strtotime('next Monday'));
			}
			else if (is_numeric($options['preselects'])) {
				// example, preselects = 7 (next seven days)
				// today is 15.05.2014 12:12:12
				// start = tomorrow = 16.05.2014 00:00:00
				// end = 7 + 1 (today) + 1 (for next day first second) = 24.05.2014 00:00:00
				$date_range['start'] = date('Y-m-d H:i:s', strtotime('tomorrow'));
				$date_range['end'] = date('Y-m-d H:i:s', strtotime('+'. ($options['preselects'] + 2) .' days midnight'));
			}

			if (!empty($date_range['start']) && !empty($date_range['end'])) {
				$this->db->where('e.datetime >=', $date_range['start']);
				$this->db->where('e.datetime <', $date_range['end']);
			}
		}

		if (!empty($options['specific_date'])) {
			$date_range['start'] = $options['specific_date'] .' 00:00:00';
			$date_range['end'] = $options['specific_date'] .' 23:59:59';
			$this->db->where('e.datetime >=', $date_range['start']);
			$this->db->where('e.datetime <=', $date_range['end']);
		}

		return $this->db->get()->result();
	}
}