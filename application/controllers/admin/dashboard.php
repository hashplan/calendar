<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends MY_Controller {

public	function __construct(){
		parent::__construct();
		if(!$this->ion_auth->in_group("admin")){
			redirect('auth/login','refresh');
		}
		$this->data['user'] = $this->ion_auth->user()->row();
		$this->load->model($this->get_user_identifier().'/events_m');
	}

public function index(){
$this->data['users'] = $this->ion_auth->users()->result();
			foreach ($this->data['users'] as $k => $user)
			{
				$this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
			}			
			$this->data['subview']='auth/index';
			$this->load->view($this->get_user_identifier().'/_layout_main', $this->data);
}

public function events(){
$this->data['events']=$this->events_m->get();
$this->data['cal'] = $this->calendar();
$this->data['subview']=$this->get_user_identifier().'/dashboard/index';
$this->load->view($this->get_user_identifier().'/_layout_main', $this->data);
}


}