<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Model extends CI_Model {
	
	function __construct(){
		parent::__construct();
		}

	public function get_trash($user_id){
		$this->db->join('user_events','user_events.eventId = events.id');
		$this->db->where('user_events.userId',$user_id);
		$this->db->where('user_events.deleted',1);
		$this->db->group_by('user_events.eventId');
		$events = $this->db->get('events')->result();
		return $events;
		}
		
	public function add_event_to_user($user_id, $event_id){
		$data = array('userId' => $user_id, 'eventId' => $event_id);
		$this->db->insert('user_events', $data);
	}	
	
	public function delete_event_from_user($user_id, $event_id){
		$data = array('userId' => $user_id, 'eventId' => $event_id, 'deleted'=>'1');
		$this->db->insert('user_events', $data);
	}		

	public function array_from_post($fields){
		$data = array();
		foreach($fields as $field){
			$data[$field]=$this->input->post($field);
		}
		return $data;
	}
}