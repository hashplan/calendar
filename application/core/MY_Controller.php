<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller {
	public $data = array();
	
	function __construct(){
		parent::__construct();
		$identifier = 'user';
		$this->data['errors']=array();
		//$this->data['site_name']=config_item('site_name');
		$this->data['meta_title']='# Plan';
		$this->load->library('ion_auth');
		$this->load->library('form_validation');
		$this->load->helper('url');

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->load->helper('language');
		
//		$this->output->cache(60);
//		$this->output->enable_profiler(TRUE);
		}
		
	public function add_event_to_user(){
	$user_id = $this->ion_auth->user()->row()->id;
	$event_id = $this->uri->segment(4);
	$this->events_m->add_event_to_user($user_id, $event_id);
	redirect($this->get_user_identifier().'/dashboard/my_plan/'.$user_id);
}

	public function delete_event_from_user(){
	$user_id = $this->ion_auth->user()->row()->id;
	$event_id = $this->uri->segment(4);
	$this->events_m->delete_event_from_user($user_id, $event_id);
	redirect($this->get_user_identifier().'/dashboard/my_plan/'.$user_id);
}

	public function my_plan(){
	$user_id = $this->ion_auth->user()->row()->id;
	$this->data['events']=$this->events_m->get($user_id);
	$this->data['cal'] = $this->calendar();
	$this->data['subview']=$this->get_user_identifier().'/dashboard/index';
	$this->load->view($this->get_user_identifier().'/_layout_main',$this->data);
}

	public function my_trash(){
	$user_id = $this->ion_auth->user()->row()->id;
	$this->data['events']=$this->events_m->get_trash($user_id);
	$this->data['cal'] = $this->calendar();
	$this->data['subview']=$this->get_user_identifier().'/dashboard/index';
	$this->load->view($this->get_user_identifier().'/_layout_main',$this->data);
}

public function get_user_identifier(){
		if($this->ion_auth->in_group("members"))
			{
				$identifier = 'user';
				}
				elseif($this->ion_auth->in_group("admin"))
				{
				$identifier = 'admin';
				}
				return $identifier;
}

public function calendar(){
$prefs = array (
               'show_next_prev'  => TRUE,
               'next_prev_url'   => 'http://localhost/calendar/user/dashboard'
             );

$this->load->library('calendar');

//hard-coded for now
$data = array(
               3  => 'http://localhost/calendar/event/modal_details/1',
               7  => 'http://localhost/calendar/event/modal_details/2',
               13 => 'http://localhost/calendar/event/modal_details/3',
               26 => 'http://localhost/calendar/event/modal_details/4'
             );

$this->data['cal'] =  $this->calendar->generate(2014,4,$data);
return $this->data['cal'];
}
}