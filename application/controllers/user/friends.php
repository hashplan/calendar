<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Friends extends MY_Controller {

	public $data = array(
		'sub_layout' => 'layouts/user_page',
	);
	public $user = NULL;

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->data['page_class'] = 'friends';
		$this->data['view'] = $this->get_user_identifier().'/dashboard/friends';
		$this->data['data']['page_title'] = 'Current friends';
		$this->data['user'] = $this->user;

		$this->load->model('users_m');
		$this->data['data']['friends'] = $this->users_m->get_friends();

		$friends_ids = array();
		foreach ($this->data['data']['friends'] as $friend) {
			$friends_ids[] = $friend->id;
		}

		$mutual_friends_count = $this->users_m->get_mutual_friends_count($friends_ids);
		foreach ($this->data['data']['friends'] as $friend) {
			$friend->mutual_friends_count = !empty($mutual_friends_count[$friend->id])
				? $mutual_friends_count[$friend->id]
				: 0;
			$friend->name = $this->users_m->generate_full_name($friend);
		}

		$this->data['data']['people_you_may_know'] = $this->users_m->get_people_user_may_know();
		foreach ($this->data['data']['people_you_may_know'] as $dude) {
			$dude->name = $this->users_m->generate_full_name($dude);
		}

		$this->_render_page();
	}

}