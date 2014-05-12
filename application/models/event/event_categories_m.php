<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Event_categories_m extends MY_Model {
	
	public function get(){
	$this->db->select('*');
	$this->db->from('eventcategories');
	$this->db->order_by('name asc');
	$event_categories = $this->db->get()->result();
	return $event_categories;
	}
}
?>