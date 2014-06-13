<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Friends extends MY_Controller {

	public $data = array(
		'sub_layout' => 'layouts/user_page',
	);
	public $user = NULL;

	public function __construct() {
		parent::__construct();
		$this->load->model('users_m');
	}

	public function index() {
		$this->data['page_class'] = 'friends';
		$this->data['view'] = $this->get_user_identifier().'/dashboard/friends';
		$this->data['data']['page_title'] = 'Current friends';
		$this->data['data']['friends_page_type'] = 'friends';
		$this->data['user'] = $this->user;

		$friends = $this->users_m->get_friends();
		$friends_ids = array();
		foreach ($friends as $friend) {
			$friends_ids[] = $friend->id;
		}

		$mutual_friends_count = $this->users_m->get_mutual_friends_count($friends_ids, $friends_ids);
		foreach ($friends as $friend) {
			$friend->mutual_friends_count = !empty($mutual_friends_count[$friend->id])
				? $mutual_friends_count[$friend->id]
				: 0;
		}

		$people_you_may_know = $this->users_m->get_people_user_may_know();
		foreach ($people_you_may_know as $dude) {
			$dude->name = $this->users_m->generate_full_name($dude);
		}
		$this->data['data']['people_you_may_know_block'] = $this->load->view('user/dashboard/people_you_may_know_block', array('people_you_may_know' => $people_you_may_know), TRUE);

		$friends_list = $this->load->view('user/dashboard/friends_list', array('people' => $friends, 'friends_page_type' => 'friends'), TRUE);
		$this->data['data']['friends_list'] = $friends_list;

		$this->_render_page();
	}

	public function add() {
		$this->data['page_class'] = 'friends';
		$this->data['view'] = $this->get_user_identifier().'/dashboard/friends';
		$this->data['data']['page_title'] = 'Add friends';
		$this->data['data']['friends_page_type'] = 'add_friends';
		$this->data['user'] = $this->user;

		$people_you_may_know = $this->users_m->get_people_user_may_know();
		$dude_ids = array();
		foreach ($people_you_may_know as $dude) {
			$dude->name = $this->users_m->generate_full_name($dude);
			$dude_ids[] = $dude->id;
		}

		$mutual_friends_count = $this->users_m->get_mutual_friends_count($dude_ids, $dude_ids);
		foreach ($people_you_may_know as $dude) {
			$dude->mutual_friends_count = !empty($mutual_friends_count[$dude->id])
				? $mutual_friends_count[$dude->id]
				: 0;
		}

		$this->data['data']['people_you_may_know_block'] = $this->load->view('user/dashboard/people_you_may_know_block', array('people_you_may_know' => $people_you_may_know), TRUE);

		$friends_list = $this->load->view('user/dashboard/friends_list', array('people' => $people_you_may_know, 'friends_page_type' => 'add_friends'), TRUE);
		$this->data['data']['friends_list'] = $friends_list;

		$this->_render_page();
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

		$this->load->view('user/dashboard/friends_list', array('people' => $friends_after_filter, 'friends_page_type' => 'friends'));
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

		$this->load->view('user/dashboard/friends_list', array('people' => $people_after_filter, 'friends_page_type' => 'add_friends'));
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

}