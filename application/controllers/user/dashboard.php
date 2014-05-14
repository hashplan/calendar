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
		$name = !empty($post['name']) && strlen(trim($post['name'])) ? trim($post['name']) : NULL;
		$offset = !empty($post['offset']) ? $post['offset'] : 0;
		$limit = 5;
		$events = $this->events_m->get_all($offset, $limit, $name);
		$this->load->view($this->get_user_identifier() . '/dashboard/events', array('events' => $events));
	}

}