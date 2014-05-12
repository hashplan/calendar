<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Events_per_metro extends MY_Controller {

public function __construct(){
		parent::__construct();
		if(!$this->ion_auth->in_group("members")){
			redirect('auth/login','refresh');
		}
		$this->data['user'] = $this->ion_auth->user()->row();
		$this->load->model('event/events_per_metro_m');
	}

public function index(){
	$this->data['events_per_metro']=$this->events_per_metro_m->get();
	$this->data['subview']='event/events_per_metro';
	$this->load->view('_layout_modal',$this->data);
	}
}