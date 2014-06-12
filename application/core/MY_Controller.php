<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller {
	public $data = array(
		'page_class' => 'generic'
	);
	public $user = NULL;
	public $layout = 'layouts/default';

	protected function _render_page() {
		$this->load->view($this->layout, $this->data);
	}

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

		$identifier = 'user';
		$this->data['errors']=array();
		$this->load->library('ion_auth');
		$this->load->library('form_validation');
		$this->load->helper('url');

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->load->helper('language');

		// Some user mess
		$this->user = $this->ion_auth->user()->row();
	}

public function get_user_identifier(){
		if($this->ion_auth->in_group("members"))
			{
				$identifier = 'user';
				}
				elseif($this->ion_auth->in_group("admin"))
				{
				$identifier = 'admin';
				}
				return $identifier;
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