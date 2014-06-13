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
		$this->data['data']['people_you_may_know_list'] = $this->load->view('user/dashboard/people_you_may_know_list', array('people_you_may_know' => $people_you_may_know), TRUE);

		$friends_list = $this->load->view('user/dashboard/friends_list', array('friends' => $friends), TRUE);
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

		$this->load->view('user/dashboard/friends_list', array('friends' => $friends_after_filter));
	}

	public function people_you_may_know() {
		$people_you_may_know = $this->users_m->get_people_user_may_know();
		foreach ($people_you_may_know as $dude) {
			$dude->name = $this->users_m->generate_full_name($dude);
		}
		$this->load->view('user/dashboard/people_you_may_know_list', array('people_you_may_know' => $people_you_may_know));
	}

	public function remove_from_lists() {
		$post = $this->input->post();
		if (!empty($post['user_id'])) {
			$this->users_m->remove_from_lists($post['user_id']);
		}
	}

}