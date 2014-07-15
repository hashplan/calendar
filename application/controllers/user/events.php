<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Events extends AuthController {
//inherits from core/my controller

	public $data = array(
		'sub_layout' => 'layouts/user_page',
	);
	public $user = NULL;
	protected $allowTypes = array('deleted', 'favourite', 'my', 'friends', 'all', 'trash');
	protected $typesView = array(
		'my' => 'index',
		'favourite' => 'index',
		'all' => 'index',
		'deleted' => 'index',
		'trash' => 'index',
		'friends' => 'friend_plans',
	);

	public	function __construct(){
		parent::__construct();
		$this->load->model('events_m');
        $this->load->model('users_m');
		$this->data['user'] = $this->user;
		$this->data['user']->metro = $this->users_m->get_user_metro($this->data['user']->id);
	}

	public function index() {
		$this->all();
	}

	public function my(){
		Menu::setActive('user/events/my');
		$user_id = $this->ion_auth->user()->row()->id;
		$this->_render_events_list_page('my', 'All my events', $user_id);
	}

	public function friends($user_id)
	{
		if(!$this->users_m->is_friend_of($user_id))
		{
			redirect(base_url('user/events'));
		}
		$this->data['user'] = $this->db->where('id', $user_id)->get('users')->row();
        $fullname = $this->data['user']->first_name . " " . $this->data['user']->last_name;
        $fullname = trim($fullname);

		$this->_render_events_list_page('friends', $fullname.' Events', $user_id);
	}

	public function all() {
		Menu::setActive('user/events/all');
		$default_location = $this->data['user']->metro;
		$this->_render_events_list_page('all', 'Events in '. $default_location->city, NULL, $default_location);
	}

	public function trash() {
		$this->_render_events_list_page('deleted', 'All deleted events');
	}

	public function favourite() {
		$this->_render_events_list_page('favourite', 'All favourite events');
	}

	public function events_list() {
		$post = $this->input->post();
		$options = array();
		if (!empty($post['category']) && $post['category'] != 0) $options['category'] = $post['category'];
		if (!empty($post['preselects']) && ($post['preselects'] === 'weekend' || $post['preselects'] != 0)) $options['preselects'] = $post['preselects'];
		if (!empty($post['offset'])) $options['offset'] = $post['offset'];
		if (!empty($post['metro_id'])) $options['metro_id'] = $post['metro_id'];
		if (!empty($post['name']) && strlen(trim($post['name']))) $options['name'] = trim($post['name']);
		if (!empty($post['specific_date'])) $options['specific_date'] = $post['specific_date'];
		if (!empty($post['user_id'])) $options['user_id'] = $post['user_id'];
		if (!empty($post['events_type']) && in_array($post['events_type'], $this->allowTypes )) {
			$options['events_type'] = $post['events_type'];
		}
		else {
			$options['events_type'] = 'all';
		}
		$current_date = !empty($post['current_date']) ? $post['current_date'] : NULL;

		$events_data= array(
			'events' => $this->events_m->get_all($options),
			'current_date' => $current_date,
			'user_id' => $options['user_id']?$options['user_id']:$this->ion_auth->user()->row()->id
		);
		$this->load->view($this->get_user_identifier() . '/events/events_'.$options['events_type'], $events_data);
	}

	public function choose_metro() {
		$this->load->model('location_m');
		$this->load->view('/event/metros',array('metros'=>$this->location_m->get_event_metro_areas(), 'hide_events' => FALSE));
	}

	protected function _render_events_list_page($events_type, $page_title, $user_id = NULL, $default_location = NULL) {
		$this->load->model('categories_m');

		$this->data['page_class'] = 'user-events';
		$this->data['view'] = $this->get_user_identifier().'/events/'.$this->typesView[$events_type];
		$this->data['user_id'] = $this->users_m->user_id_is_correct($user_id) ? $user_id : $this->user->id;

		$events_search_params = array('events_type' => $events_type, 'user_id' => $user_id);
		if ($default_location !== NULL) {
			$events_search_params['metro_id'] = $default_location->metroId;
			$this->data['metro_id'] = $default_location->metroId;
			$this->data['metro_name'] = $default_location->city;
		}
		$events = $this->events_m->get_all($events_search_params);
		$events_data = array(
			'events' => $events,
			'categories' => $this->categories_m->get_top_level_categories(),
			'current_date' => NULL,
			'user_id' => $this->data['user_id']
		);
		$this->data['data']['events'] = $this->load->view($this->get_user_identifier() . '/events/events_' . $events_type, $events_data, true);

		$this->data['data']['has_events'] = count($events) > 0;
		$this->data['data']['events_type'] = $events_type;
		$this->data['data']['page_title'] = $page_title;

		$this->_render_page();
	}

}