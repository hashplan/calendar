<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Modal_details_m extends MY_Model {
	
	public function get_where($event_id){
	$event = $this->db->get_where('events', array('eventId' => $event_id))->row();
	return $event;
	}
}
?>