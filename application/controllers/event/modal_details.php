<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Modal_details extends MY_Controller {

public function __construct(){
		parent::__construct();
		if(!$this->ion_auth->in_group("members")){
			redirect('auth/login','refresh');
		}
		$this->data['user'] = $this->ion_auth->user()->row();
		$this->load->model('event/modal_details_m');
	}

public function index(){
	$event_id = $this->uri->segment(3);
	$this->data['event']=$this->modal_details_m->get_where($event_id);
	$this->data['subview']='event/index';
	$this->load->view('_layout_modal',$this->data);
	}
}