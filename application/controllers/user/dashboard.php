<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends MY_Controller {
//inherits from core/my controller

public	function __construct(){
		parent::__construct();
		if(!$this->ion_auth->in_group("members")){
			redirect('auth/login','refresh');
		}
		$this->data['user'] = $this->ion_auth->user()->row();
		$this->load->model($this->get_user_identifier().'/events_m');
	}

public function index(){
	$this->data['events']=$this->events_m->get();
	$this->load->model('event/event_categories_m');
	$this->data['event_categories'] = $this->event_categories_m->get();
	$this->data['cal'] = $this->calendar();
	$this->data['subview']=$this->get_user_identifier().'/dashboard/index';
	$this->load->view($this->get_user_identifier().'/_layout_main',$this->data);
}

public function events_autocomplete(){
	if (isset($_GET['term'])){
      $q = strtolower($this->input->get('term'));
	  $this->events_m->events_autocomplete($q);
    }	
  }
  
 
}