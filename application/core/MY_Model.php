<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Model extends CI_Model {
	
	function __construct(){
		parent::__construct();
		}

	public function get($name = NULL, $user_id = NULL){
	//if user id is passed, get events user has signed up for, otherwise get list of all events
		if($user_id !=NULL){
			$this->db->select('events.id as eventId,events.name,events.datetime');
			$this->db->from('events');
			$this->db->join('user_events','user_events.eventId = events.id');
			$this->db->where('user_events.userId',$user_id);
			$this->db->where('user_events.deleted',0);
			if ($name !== NULL) {
				$this->db->like('events.name', $name);
			}
			$this->db->group_by('user_events.eventId');
			$events = $this->db->get()->result();
			return $events;
		}
		else{
			//$this->db->where('events.datetime>=', Date("Ymd");
			$this->db->select('events.id as eventId,events.name,events.datetime');
			$this->db->from('events');
			if ($name !== NULL) {
				$this->db->like('events.name', $name);
			}
			$this->db->limit(50,0);
			$events=$this->db->get()->result();
			return $events;
		}
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

}