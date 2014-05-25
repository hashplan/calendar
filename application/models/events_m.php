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
			->select('e.id, e.name, e.datetime, DATE(e.datetime) AS date_only')
			->from('events AS e')
			->join('venues AS v', 'e.venueId = v.id', 'inner')
			->order_by('e.datetime')
			->limit($options['limit'], $options['offset']);

		if (!empty($options['category'])) {
			$this->load->model('categories_m');
			$categories = $this->categories_m->get_child_categories($options['category']);
			$category_ids = array();
			foreach ($categories as $cat) {
				$category_ids[] = $cat->id;
			}
			$this->db->join('event_categories AS ec', 'e.id = ec.event_id', 'inner');
			$this->db->join('categories AS c', 'ec.category_id = c.id', 'inner');
			$this->db->where_in('c.id', $category_ids);
		}

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
		}

		if (!empty($options['specific_date'])) {
			$date_range['start'] = $options['specific_date'] .' 00:00:00';
			$date_range['end'] = $options['specific_date'] .' 23:59:59';
		}

		if (empty($options['specific_date']) && empty($options['preselects'])) {
			$date_range['start'] = date('Y-m-d') .' 00:00:00';
			$date_range['end'] = date('Y-m-d', strtotime('+5 years')) .' 23:59:59';
		}

		$this->db->where('e.datetime >=', $date_range['start']);
		$this->db->where('e.datetime <=', $date_range['end']);

		return $this->db->get()->result();
	}

	public function get_event_by_id($id) {
		return $this->db
			->select('
				e.id AS event_id,
				e.name AS event_name,
				e.description AS event_description,
				e.typeId AS event_typeId,
				e.datetime AS event_datetime,
				e.venueId AS event_venueId,
				e.stubhub_url AS event_stubhub_url,
				e.insertedon AS event_insertedon,
				e.insertedby AS event_insertedby,
				e.updatedon AS event_updatedon,
				e.updatedby AS event_updatedby,
				v.id AS venue_id,
				v.name AS venue_name,
				v.address AS venue_address,
				v.city AS venue_city,
				v.cityId AS venue_cityId,
				v.stateId AS venue_stateId,
				v.zip AS venue_zip,
				v.phone AS venue_phone,
				v.website AS venue_website,
				v.description AS venue_description,
				v.typeId AS venue_typeId,
				v.insertedon AS venue_insertedon,
				v.insertedby AS venue_insertedby,
				v.updatedon AS venue_updatedon,
				v.updatedby AS venue_updatedby,
				c.id AS city_id,
				c.city AS city_city,
				c.stateId AS city_state_id
			')
			->from('events AS e')
			->join('venues AS v', 'e.venueId = v.id', 'inner')
			->join('cities AS c', 'v.cityId = c.id', 'left')
			->where('e.id', $id)
			->get()
			->row();
	}
	
	public function get_new_user_added_event(){
	$user_added_event = new stdClass();
	$user_added_event->name = '';
	$user_added_event->description = '';
	$user_added_event->typeId = '';
	$user_added_event->datetime = '';
	$user_added_event->venueId = '';
	$user_added_event->stubhub_url = '';
	$user_added_event->insertedon = '';
	$user_added_event->insertedby = '';
	$user_added_event->updatedon = '';
	$user_added_event->updatedby = '';
	return $user_added_event;
	}
	
	
	public function save_user_added_event($data, $id = NULL){
		//set timestamps
			$now = date('Y-m-d H:i:s');
			$data['insertedon']=$now;
			$data['updatedon']=$now;
		//insert
			if($id === NULL){
				$this->db->insert($this->table_name);
				$id = $this->db->insert_id();
			}
		//update
			else{
				$this->db->where('user_added_event.id',$id);
				$this->db->update($this->table_name);
			}
			return $id;
	}
}