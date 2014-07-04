<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Friends extends AuthController {

	public $data = array(
		'sub_layout' => 'layouts/user_page',
	);
	public $user = NULL;

	public function __construct() {
		parent::__construct();
		$this->load->model('users_m');
	}

	public function index() {
		Menu::setActive('user/friends/friends_current');
		$page_class = 'friends';
		$page_title = 'Current friends';
		$page_type = 'friends';
		$this->load->model('location_m');
		$users = $this->users_m->get_friends();
		$locations = $this->location_m->get_left_block_metro_areas();
		$left_block = $this->load->view('user/dashboard/locations_left_block', array('locations' => $locations), TRUE);
		$this->_render_users_page($page_class, $page_title, $page_type, $left_block, $users);
	}

	public function add() {
		Menu::setActive('user/friends/friends_add');
		$page_class = 'friends';
		$page_title = 'Add friends';
		$page_type = 'add_friends';
		$this->load->model('location_m');
		$users = $this->users_m->get_people_user_may_know();
		$locations = $this->location_m->get_left_block_metro_areas();
		$left_block = $this->load->view('user/dashboard/locations_left_block', array('locations' => $locations), TRUE);

		$this->_render_users_page($page_class, $page_title, $page_type, $left_block, $users);
	}

	public function invites($invite_type = NULL) {
		Menu::setActive('user/invites');
		$users_which_sent_friend_request = $this->users_m->get_users_which_sent_friend_request();
		$users_which_sent_event_invite = $this->users_m->get_users_which_sent_event_invite();
		$users_you_sent_friend_request = $this->users_m->get_users_you_sent_friend_request();
		$users_you_sent_event_invite = $this->users_m->get_users_you_sent_event_invite();
		$users_you_sent_invites = array_merge($users_you_sent_friend_request, $users_you_sent_event_invite);
		$counts = array(
			'received_friend_requests' => count($users_which_sent_friend_request),
			'received_event_invites' => count($users_which_sent_event_invite),
			'sent_invites' => count($users_you_sent_invites),
		);
		if ($invite_type === 'sent') {
			$this->_invites_sent($users_you_sent_invites, $counts);
		}
		else if ($invite_type === 'events') {
			$this->_invites_events($users_which_sent_event_invite, $counts);
		}
		else {
			$this->_invites_received($users_which_sent_friend_request, $counts);
		}
	}

	protected function _invites_received($users, $counts) {
		$page_class = 'friends';
		$page_title = 'Invites to connect with friends';
		$page_type = 'friends_invites';
		$left_block = $this->load->view('user/dashboard/invites_left_block', array('counts' => $counts), TRUE);
		$this->_render_users_page($page_class, $page_title, $page_type, $left_block, $users);
	}

	protected function _invites_events($users, $counts) {
		$page_class = 'friends';
		$page_title = 'Invites to visit events';
		$page_type = 'events_invites';
		$left_block = $this->load->view('user/dashboard/invites_left_block', array('counts' => $counts), TRUE);
		$this->_render_users_page($page_class, $page_title, $page_type, $left_block, $users);
	}

	protected function _invites_sent($users, $counts) {
		$page_class = 'friends';
		$page_title = 'Sent invites';
		$page_type = 'invites_sent';
		$left_block = $this->load->view('user/dashboard/invites_left_block', array('counts' => $counts), TRUE);
		$this->_render_users_page($page_class, $page_title, $page_type, $left_block, $users);
	}

	public function friends_list() {
		$post = $this->input->post();
		$options = array();
		if (!empty($post['name']) && strlen(trim($post['name']))) $options['name'] = trim($post['name']);
		$options['location_ids'] = empty($post['location_ids']) ? array('all') : $post['location_ids'];
		if (!empty($post['location_name'])) {
			$options['location_name'] = $post['location_name'];
		}

		$friends_all = $this->users_m->get_friends();
		$friends_after_filter = $this->users_m->get_friends($options);

		$friends_all_ids = array();
		foreach ($friends_all as $friend) {
			$friends_all_ids[] = $friend->id;
		}
		$friend = NULL;

		$friends_after_filter_ids = array();
		foreach ($friends_after_filter as $friend) {
			$friends_after_filter_ids[] = $friend->id;
		}

		$mutual_friends_count = $this->users_m->get_mutual_friends_count($friends_after_filter_ids, $friends_all_ids);
		foreach ($friends_after_filter as $friend) {
			$friend->mutual_friends_count = !empty($mutual_friends_count[$friend->id])
				? $mutual_friends_count[$friend->id]
				: 0;
		}

		$this->load->view('user/dashboard/users_list', array('people' => $friends_after_filter, 'page_type' => 'friends'));
	}

	public function inviters_list() {
		$post = $this->input->post();
		$options = array();
		if (!empty($post['name']) && strlen(trim($post['name']))) $options['name'] = trim($post['name']);

		$friends_all = $this->users_m->get_friends();
		$friends_after_filter = $this->users_m->get_users_which_sent_friend_request($options);

		$friends_all_ids = array();
		foreach ($friends_all as $friend) {
			$friends_all_ids[] = $friend->id;
		}
		$friend = NULL;

		$friends_after_filter_ids = array();
		foreach ($friends_after_filter as $friend) {
			$friends_after_filter_ids[] = $friend->id;
		}

		$mutual_friends_count = $this->users_m->get_mutual_friends_count($friends_after_filter_ids, $friends_all_ids);
		foreach ($friends_after_filter as $friend) {
			$friend->mutual_friends_count = !empty($mutual_friends_count[$friend->id])
				? $mutual_friends_count[$friend->id]
				: 0;
		}

		$this->load->view('user/dashboard/users_list', array('people' => $friends_after_filter, 'page_type' => 'friends_invites'));
	}

	public function inviters_events_list() {
		$post = $this->input->post();
		$options = array();
		if (!empty($post['name']) && strlen(trim($post['name']))) $options['name'] = trim($post['name']);

		$friends_all = $this->users_m->get_friends();
		$inviters_after_filter = $this->users_m->get_users_which_sent_event_invite($options);

		$friends_all_ids = array();
		foreach ($friends_all as $friend) {
			$friends_all_ids[] = $friend->id;
		}
		$friend = NULL;

		$inviters_after_filter_ids = array();
		foreach ($inviters_after_filter as $inviter) {
			$inviters_after_filter_ids[] = $inviter->id;
		}

		$mutual_friends_count = $this->users_m->get_mutual_friends_count($inviters_after_filter_ids, $friends_all_ids);
		foreach ($inviters_after_filter as $inviter) {
			$inviter->mutual_friends_count = !empty($mutual_friends_count[$inviter->id])
				? $mutual_friends_count[$inviter->id]
				: 0;
		}

		$this->load->view('user/dashboard/users_list', array('people' => $inviters_after_filter, 'page_type' => 'events_invites'));
	}

	public function invited_list() {
		$post = $this->input->post();
		$options = array();
		if (!empty($post['name']) && strlen(trim($post['name']))) $options['name'] = trim($post['name']);

		$friends_all = $this->users_m->get_friends();
		$friend_request_receivers = $this->users_m->get_users_you_sent_friend_request($options);

		$friends_all_ids = array();
		foreach ($friends_all as $friend) {
			$friends_all_ids[] = $friend->id;
		}

		$friend_request_receivers_after_filter_ids = array();
		foreach ($friend_request_receivers as $receiver) {
			$friend_request_receivers_after_filter_ids[] = $receiver->id;
		}
		$receiver = NULL;

		$mutual_friends_count = $this->users_m->get_mutual_friends_count($friend_request_receivers_after_filter_ids, $friends_all_ids);
		foreach ($friend_request_receivers as $receiver) {
			$receiver->mutual_friends_count = !empty($mutual_friends_count[$receiver->id])
				? $mutual_friends_count[$receiver->id]
				: 0;
		}
		$receiver = NULL;

		$event_invite_receivers = $this->users_m->get_users_you_sent_event_invite($options);
		$event_invite_receivers_after_filter_ids = array();
		foreach ($event_invite_receivers as $receiver) {
			$event_invite_receivers_after_filter_ids[] = $receiver->id;
		}
		$receiver = NULL;

		$mutual_friends_count = $this->users_m->get_mutual_friends_count($event_invite_receivers_after_filter_ids, $friends_all_ids);
		foreach ($event_invite_receivers as $receiver) {
			$receiver->mutual_friends_count = !empty($mutual_friends_count[$receiver->id])
				? $mutual_friends_count[$receiver->id]
				: 0;
		}

		$people = array_merge($friend_request_receivers, $event_invite_receivers);

		$this->load->view('user/dashboard/users_list', array('people' => $people, 'page_type' => 'invites_sent'));
	}

	public function people_you_may_know_list() {
		$post = $this->input->post();
		$options = array();
		if (!empty($post['name']) && strlen(trim($post['name']))) $options['name'] = trim($post['name']);
		$options['location_ids'] = empty($post['location_ids']) ? array('all') : $post['location_ids'];
		if (!empty($post['location_name'])) {
			$options['location_name'] = $post['location_name'];
		}

		$friends_all = $this->users_m->get_friends();
		$people_after_filter = $this->users_m->get_people_user_may_know($options);

		$friends_all_ids = array();
		foreach ($friends_all as $friend) {
			$friends_all_ids[] = $friend->id;
		}
		$friend = NULL;

		$people_after_filter_ids = array();
		foreach ($people_after_filter as $friend) {
			$people_after_filter_ids[] = $friend->id;
		}

		$mutual_friends_count = $this->users_m->get_mutual_friends_count($people_after_filter_ids, $friends_all_ids);
		foreach ($people_after_filter as $friend) {
			$friend->mutual_friends_count = !empty($mutual_friends_count[$friend->id])
				? $mutual_friends_count[$friend->id]
				: 0;
		}

		$this->load->view('user/dashboard/users_list', array('people' => $people_after_filter, 'page_type' => 'add_friends'));
	}

	public function people_you_may_know_block() {
		$people_you_may_know = $this->users_m->get_people_user_may_know();
		foreach ($people_you_may_know as $dude) {
			$dude->name = $this->users_m->generate_full_name($dude);
		}
		$this->load->view('user/dashboard/people_you_may_know_block', array('people_you_may_know' => $people_you_may_know));
	}

	public function remove_from_lists($user_id) {
		if ($this->users_m->user_id_is_correct($user_id)) {
			$this->users_m->delete_connection_between_users($user_id, NULL);
			$this->users_m->set_connection_between_users($user_id, NULL, NULL, 'removed');
			if (!$this->input->is_ajax_request()) {
				redirect(base_url() .'user/friends');
			}
		}
	}

	public function friend_request($friend_id = NULL) {
		$this->users_m->set_connection_between_users($friend_id, NULL, NULL, 'friend_request');
		redirect('user/friends/add');
	}

	public function friend_accept($friend_id = NULL) {
		$this->users_m->set_connection_between_users($friend_id, NULL, 'friend_request', 'friend');
		redirect('user/friends/invites');
	}

	public function event_invite_accept($inviter_id, $event_id) {
		$this->users_m->set_connection_between_users($inviter_id, NULL, 'event_invite', 'event_invite_accept', $event_id);
		// todo: moar logic
		redirect('user/friends/invites/events');
	}

	public function locations_autocomplete() {
		$this->load->model('location_m');
		$locations_raw = $this->location_m->get_all_metro_areas();
		$locations = array();
		foreach ($locations_raw as $location) {
			$locations[] = array('id' => $location->id, 'city' => $location->city);
		}
		header('Content-Type: application/json');
		echo json_encode($locations);
		die();
	}

	protected function _render_users_page($page_class, $page_title, $page_type, $left_block, $users) {
		$this->data['page_class'] = $page_class;
		$this->data['view'] = $this->get_user_identifier().'/dashboard/users';
		$this->data['data']['page_title'] = $page_title;
		$this->data['data']['page_type'] = $page_type;
		$this->data['data']['left_block'] = $left_block;
		$this->data['user'] = $this->user;

		$users_ids = array();
		foreach ($users as $user) {
			$users_ids[] = $user->id;
		}

		$mutual_friends_count = $this->users_m->get_mutual_friends_count($users_ids, $users_ids);
		foreach ($users as $user) {
			$user->mutual_friends_count = !empty($mutual_friends_count[$user->id])
				? $mutual_friends_count[$user->id]
				: 0;
		}

		$people_you_may_know = $this->users_m->get_people_user_may_know();
		foreach ($people_you_may_know as $dude) {
			$dude->name = $this->users_m->generate_full_name($dude);
		}
		$this->data['data']['people_you_may_know_block'] = $this->load->view('user/dashboard/people_you_may_know_block', array('people_you_may_know' => $people_you_may_know), TRUE);

		$users_list = $this->load->view('user/dashboard/users_list', array('people' => $users, 'page_type' => $page_type), TRUE);
		$this->data['data']['users_list'] = $users_list;

		$this->_render_page();
	}

	public function send_multiple_event_invites() {
		$post = $this->input->post();
		$friend_ids = !empty($post['friend_ids']) ? $post['friend_ids'] : NULL;
		$event_id_is_correct = $post['event_id'] !== NULL && is_numeric($post['event_id']) && $post['event_id'] > 0;
		if ($friend_ids === NULL || !$event_id_is_correct) {
			return;
		}
		foreach ($friend_ids as $friend_id) {
			$this->users_m->set_connection_between_users($friend_id, NULL, NULL, 'event_invite', $post['event_id']);
		}
	}

}