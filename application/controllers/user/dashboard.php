<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends MY_Controller {
//inherits from core/my controller

	public $data = array(
		'sub_layout' => 'layouts/user_page',
	);

	public	function __construct(){
		parent::__construct();
		if(!$this->ion_auth->in_group("members")){
			redirect('auth/login','refresh');
		}
		$this->data['user'] = $this->ion_auth->user()->row();
		$this->load->model('events_m');
	}

	public function index(){
		$this->_render_events_list_page('my');
	}

	public function all() {
		$this->_render_events_list_page('all');
	}

	public function trash() {
		$this->_render_events_list_page('deleted');
	}

	public function favourite() {
		$this->_render_events_list_page('favourite');
	}

	public function events_list() {
		$post = $this->input->post();
		$options = array();
		if (!empty($post['category']) && $post['category'] != 0) $options['category'] = $post['category'];
		if (!empty($post['preselects']) && ($post['preselects'] === 'weekend' || $post['preselects'] != 0)) $options['preselects'] = $post['preselects'];
		if (!empty($post['offset'])) $options['offset'] = $post['offset'];
		if (!empty($post['city_id'])) $options['city_id'] = $post['city_id'];
		if (!empty($post['name']) && strlen(trim($post['name']))) $options['name'] = trim($post['name']);
		if (!empty($post['specific_date'])) $options['specific_date'] = $post['specific_date'];
		if (!empty($post['events_type']) && in_array($post['events_type'], array('deleted', 'favourite', 'my'))) {
			$options['events_type'] = $post['events_type'];
		}
		else {
			$options['events_type'] = 'all';
		}
		$events = $this->events_m->get_all($options);
		$this->load->view($this->get_user_identifier() . '/dashboard/events', array('events' => $events));
	}

	public function choose_city() {
		$this->load->model('location_m');
		$this->load->view('/event/cities', array('cities' => $this->location_m->get_cities()));
	}
	
	protected function _render_events_list_page($events_type) {
		$this->data['page_class'] = 'user-events';
		$this->data['view'] = $this->get_user_identifier().'/dashboard/index';

		$this->load->model('categories_m');
		$events = $this->events_m->get_all(array('events_type' => $events_type));
		$events_data = array(
			'events' => $events,
			'categories' => $this->categories_m->get_top_level_categories(),
		);
		$this->data['data']['events'] = $this->load->view($this->get_user_identifier() . '/dashboard/events', $events_data, true);

		$this->data['data']['has_events'] = count($events) > 0;
		$this->data['data']['events_type'] = $events_type;

		$this->_render_page();
	}

}