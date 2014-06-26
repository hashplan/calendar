<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_settings extends AuthController {

	public $data = array(
		'sub_layout' => 'layouts/user_page',
	);

	public	function __construct(){
		parent::__construct();
		$this->data['user'] = $this->ion_auth->user()->row();
//		$this->load->model('user/account_settings_m');
	}

	//user_profile table needs to be completely redesigned - and probably renamed "user_account_settinngs" -  since now we have the full crawler data available
	//also category and subcategory tables are no longer needed
	public function index(){
//		$user_id = $this->ion_auth->user()->row()->id;
//		$this->data['account_settings'] = $this->account_settings_m->get_account_settings($user_id);
//		$this->data['subview']='user/account_settings/index';
//		$this->load->view('user/_layout_main',$this->data);

		$this->load->helper(array('form', 'url'));
		$this->load->model('users_m');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('first_name', 'First name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password_confirm', 'Confirm password');
		$form_is_valid = count($_POST) ? $this->form_validation->run() : TRUE;

		$this->data['update_result'] = FALSE;
		$this->data['updated'] = FALSE;
		if ($form_is_valid && count($_POST)) {
			$user_data = $_POST;
			$user_data['id'] = $this->data['user']->id;
			$this->data['updated'] = TRUE;
			$this->data['update_result'] = $this->users_m->save_user($user_data);
		}

		$this->data['page_class'] = 'account-settings';
		$this->data['view'] = 'user/account_settings/index';
		$this->data['form_is_valid'] = $form_is_valid;
		$this->data['validation_errors'] = validation_errors();

		$user_metro = $this->users_m->get_user_metro($this->data['user']->id);
		$this->data['metro_name'] = $user_metro->city;
		$this->data['metro_id'] = $user_metro->metroId;

		$this->_render_page();
	}

	public function avatar_upload(){
		if($this->input->post('upload')){
			$user_id = $this->ion_auth->user()->row()->id;
			$this->account_settings_m->avatar_upload($user_id);
		}
		$this->data['subview']='user/account_settings/index';
		$this->load->view('user/_layout_main',$this->data);
	}

	public function choose_metro() {
		$this->load->model('location_m');
		$this->load->view('/event/metros',array('metros'=>$this->location_m->get_all_metro_areas(), 'hide_events' => TRUE));
	}

}