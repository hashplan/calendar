<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller {
	public $data = array(
		'page_class' => 'generic'
	);
	public $layout = 'layouts/default';

	function __construct() {
		parent::__construct();
		// Set default empty data if missing
		if (empty($this->data)) {
			$this->data = array();
		}

		// Set layout if missing
		if (empty($this->layout)) {
			$this->layout = 'default';
		}

		// Set page_class if missing
		if (empty($this->data['page_class'])) {
			$this->data['page_class']= 'generic';
		}

		if (empty($this->data['data'])) {
			$this->data['data'] = array();
		}

		$this->data['errors']=array();
	}

    protected function _render_page() {
        $this->load->view($this->layout, $this->data);
    }

    public function calendar(){
        $prefs = array (
            'show_next_prev'  => TRUE,
            'next_prev_url'   => 'http://localhost/calendar/user/events'
        );

        $this->load->library('calendar');

        //hard-coded for now
        $data = array(
            3  => 'http://localhost/calendar/event/modal_details/1',
            7  => 'http://localhost/calendar/event/modal_details/2',
            13 => 'http://localhost/calendar/event/modal_details/3',
            26 => 'http://localhost/calendar/event/modal_details/4'
        );

        $this->data['cal'] =  $this->calendar->generate(2014,4,$data);
        return $this->data['cal'];
    }
}


//Protocontroller for authorized users
class AuthController extends MY_Controller{
    public $user = NULL;

    public	function __construct(){
        parent::__construct();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');

        if(!$this->ion_auth->in_group("members")){
            redirect('auth/login','refresh');
        }

        // Some user mess
        $this->user = $this->ion_auth->user()->row();
    }

    public function get_user_identifier(){
        if($this->ion_auth->in_group("members")){
            $identifier = 'user';
        }elseif($this->ion_auth->in_group("admin")){
            $identifier = 'admin';
        }
        return $identifier;
    }
}

//Protocontroller for admin
class AdminController extends AuthController{

    public	function __construct(){
        parent::__construct();

        if(!$this->ion_auth->in_group("admin")){
            show_404();
        }
    }
}