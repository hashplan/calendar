<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Profile extends MY_Controller {

public	function __construct(){
		parent::__construct();
		if(!$this->ion_auth->in_group("members")){
			redirect('auth/login','refresh');
		}
		$this->data['user'] = $this->ion_auth->user()->row();
		$this->load->model('user/events_m');
	}

public function index(){
	$user_id = $this->ion_auth->user()->row()->id;
	$this->load->model('user/profile_m');
	$this->data['user_profile'] = $this->profile_m->get_profile($user_id);
	$this->data['subview']='user/profile/index';
	$this->load->view('user/_layout_main',$this->data);
}
 
}