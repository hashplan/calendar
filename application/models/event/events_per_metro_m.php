<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Events_per_metro_m extends MY_Model {
	
	public function get(){
	//need to work on this long join
	
	
	
	/*$this->db->select("metroareas.id, metroareas.city, count(metroareas.id) as count");
	$this->db->from("metroareas");
	$this->db->join('events','events.id = metroareas.id  RL.metroId = MA.id');
	$this->db->join('venues','venues.id = events.venueId');
	$this->db->group_by("metroareas.id, metroareas.city");
	$this->db->order_by("city asc");
	$events_per_metro = $this->db->get()->result();
	*/
	$events_per_metro = "just testing here";
	return $events_per_metro;
	}
}
?>