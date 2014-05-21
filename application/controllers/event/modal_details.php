<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Modal_details extends MY_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->ion_auth->in_group("members")){
			redirect('auth/login','refresh');
		}
		$this->data['user'] = $this->ion_auth->user()->row();
	}

	public function index($event_id) {
		$this->load->model('events_m');
		$event = $this->events_m->get_event_by_id($event_id);
		$this->data['event'] = $event;
		$this->data['subview'] = 'event/index';
		$this->load->view('_layout_modal', $this->data);
	}
}