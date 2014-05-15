<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends MY_Controller {
//inherits from core/my controller

	public $page_class = 'dashboard';

	public	function __construct(){
		parent::__construct();
		if(!$this->ion_auth->in_group("members")){
			redirect('auth/login','refresh');
		}
		$this->data['user'] = $this->ion_auth->user()->row();
		$this->load->model('events_m');
	}

	public function index(){
		$this->load->model('event/event_categories_m');
		$this->data['event_categories'] = $this->event_categories_m->get();
		$this->data['cal'] = $this->calendar();
		$this->data['subview']=$this->get_user_identifier().'/dashboard/index';
		$this->data['events'] = $this->load->view($this->get_user_identifier() . '/dashboard/events', array('events' => $this->events_m->get_all()), true);
		$this->load->view($this->get_user_identifier().'/_layout_main',$this->data);
	}

	public function events_list() {
		$post = $this->input->post();
		$options = array();
		if (!empty($post['preselects']) && ($post['preselects'] === 'weekend' || $post['preselects'] != 0)) $options['preselects'] = $post['preselects'];
		if (!empty($post['offset'])) $options['offset'] = $post['offset'];
		if (!empty($post['city_id'])) $options['city_id'] = $post['city_id'];
		if (!empty($post['name']) && strlen(trim($post['name']))) $options['name'] = trim($post['name']);
		if (!empty($post['specific_date'])) $options['specific_date'] = $post['specific_date'];
		$events = $this->events_m->get_all($options);
		$this->load->view($this->get_user_identifier() . '/dashboard/events', array('events' => $events));
	}

	public function choose_city() {
		$this->load->model('location_m');
		$this->load->view('/event/cities', array('cities' => $this->location_m->get_cities()));
	}

}