<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_settings extends AuthController {

    public	function __construct(){
		parent::__construct();
		$this->data['user'] = $this->ion_auth->user()->row();
		$this->load->model('user/account_settings_m');
    }

	//user_profile table needs to be completely redesigned - and probably renamed "user_account_settinngs" -  since now we have the full crawler data available
	//also category and subcategory tables are no longer needed
    public function index(){
        $user_id = $this->ion_auth->user()->row()->id;
        $this->data['account_settings'] = $this->account_settings_m->get_account_settings($user_id);
        $this->data['subview']='user/account_settings/index';
        $this->load->view('user/_layout_main',$this->data);
    }

    public function avatar_upload(){
        if($this->input->post('upload')){
            $user_id = $this->ion_auth->user()->row()->id;
            $this->account_settings_m->avatar_upload($user_id);
        }
        $this->data['subview']='user/account_settings/index';
        $this->load->view('user/_layout_main',$this->data);
    }
 
}