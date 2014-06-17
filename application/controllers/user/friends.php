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
		$left_block = '';
		$users = $this->users_m->get_friends();
		$this->_render_users_page($page_class, $page_title, $page_type, $left_block, $users);
	}

	public function add() {
        Menu::setActive('user/friends/friends_add');
		$page_class = 'friends';
		$page_title = 'Add friends';
		$page_type = 'add_friends';
		$left_block = '';
		$users = $this->users_m->get_people_user_may_know();
		$this->_render_users_page($page_class, $page_title, $page_type, $left_block, $users);
	}

	public function invites($invite_type = NULL) {
        Menu::setActive('user/invites');
		if ($invite_type === 'sent') {
			$this->_invites_sent();
		}
		else {
			$this->_invites_received();
		}
	}

	protected function _invites_received() {
		$page_class = 'friends';
		$page_title = 'Invites to connect with friends';
		$page_type = 'friends_invites';
		$left_block = $this->load->view('user/dashboard/invites_left_block', array(), TRUE);
		$users = $this->users_m->get_inviters();
		$this->_render_users_page($page_class, $page_title, $page_type, $left_block, $users);
	}

	protected function _invites_sent() {
		$page_class = 'friends';
		$page_title = 'Sent invites';
		$page_type = 'friends_invites_sent';
		$left_block = $this->load->view('user/dashboard/invites_left_block', array(), TRUE);
		$users = $this->users_m->get_invited();
		$this->_render_users_page($page_class, $page_title, $page_type, $left_block, $users);
	}

	public function friends_list() {
		$post = $this->input->post();
		$options = array();
		if (!empty($post['name']) && strlen(trim($post['name']))) $options['name'] = trim($post['name']);

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

		$this->load->view('user/dashboard/users_list', array('people' => $friends_after_filter, 'friends_page_type' => 'friends'));
	}

	public function inviters_list() {
		$post = $this->input->post();
		$options = array();
		if (!empty($post['name']) && strlen(trim($post['name']))) $options['name'] = trim($post['name']);

		$friends_all = $this->users_m->get_friends();
		$friends_after_filter = $this->users_m->get_inviters($options);

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

		$this->load->view('user/dashboard/users_list', array('people' => $friends_after_filter, 'friends_page_type' => 'friends_invites'));
	}

	public function invited_list() {
		$post = $this->input->post();
		$options = array();
		if (!empty($post['name']) && strlen(trim($post['name']))) $options['name'] = trim($post['name']);

		$friends_all = $this->users_m->get_friends();
		$friends_after_filter = $this->users_m->get_invited($options);

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

		$this->load->view('user/dashboard/users_list', array('people' => $friends_after_filter, 'friends_page_type' => 'friends_invites_sent'));
	}

	public function people_you_may_know_list() {
		$post = $this->input->post();
		$options = array();
		if (!empty($post['name']) && strlen(trim($post['name']))) $options['name'] = trim($post['name']);

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

		$this->load->view('user/dashboard/users_list', array('people' => $people_after_filter, 'friends_page_type' => 'add_friends'));
	}

	public function people_you_may_know_block() {
		$people_you_may_know = $this->users_m->get_people_user_may_know();
		foreach ($people_you_may_know as $dude) {
			$dude->name = $this->users_m->generate_full_name($dude);
		}
		$this->load->view('user/dashboard/people_you_may_know_block', array('people_you_may_know' => $people_you_may_know));
	}

	public function remove_from_lists() {
		$post = $this->input->post();
		if (!empty($post['user_id'])) {
			$this->users_m->set_connection_between_users($post['user_id'], NULL, 'removed');
		}
	}

	public function friend_request($user_id = NULL) {
		$this->users_m->set_connection_between_users($user_id, NULL, 'friend_request');
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

		$users_list = $this->load->view('user/dashboard/users_list', array('people' => $users, 'friends_page_type' => 'friends'), TRUE);
		$this->data['data']['users_list'] = $users_list;

		$this->_render_page();
	}

}