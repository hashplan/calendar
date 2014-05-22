<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends MY_Controller {
//inherits from core/my controller

	public $page_class = 'dashboard';

	public	function __construct(){
		parent::__construct();
		if(!$this->ion_auth->in_group("members")){
			redirect('auth/login','refresh');
		}
		$this->data['user'] = $this->ion_auth->user()->row();
		$this->load->model('events_m');
	}

	public function index(){
		$this->load->model('categories_m');
		$events_data = array(
			'events' => $this->events_m->get_all(),
			'categories' => $this->categories_m->get_top_level_categories(),
		);
		$this->data['cal'] = $this->calendar();
		$this->data['subview']=$this->get_user_identifier().'/dashboard/index';
		$this->data['events'] = $this->load->view($this->get_user_identifier() . '/dashboard/events', $events_data, true);
		$this->load->view($this->get_user_identifier().'/_layout_main',$this->data);
	}

	public function events_list() {
		$post = $this->input->post();
		$options = array();
		if (!empty($post['category']) && $post['category'] != 0) $options['category'] = $post['category'];
		if (!empty($post['preselects']) && ($post['preselects'] === 'weekend' || $post['preselects'] != 0)) $options['preselects'] = $post['preselects'];
		if (!empty($post['offset'])) $options['offset'] = $post['offset'];
		if (!empty($post['city_id'])) $options['city_id'] = $post['city_id'];
		if (!empty($post['name']) && strlen(trim($post['name']))) $options['name'] = trim($post['name']);
		if (!empty($post['specific_date'])) $options['specific_date'] = $post['specific_date'];
		$events = $this->events_m->get_all($options);
		$this->load->view($this->get_user_identifier() . '/dashboard/events', array('events' => $events));
	}

	public function choose_city() {
		$this->load->model('location_m');
		$this->load->view('/event/cities', array('cities' => $this->location_m->get_cities()));
	}
	
	public function private_event($id = NULL){
		//retrieve an event or set a new one
		if($id){
			$this->data['private_event'] = $this->events_m->get_event_by_id($id);
			count($this->data['private_event'])||$this->data['errors'][]='Private event could not be found';
		}
		else {
			$this->data['private_event'] = $this->events_m->get_new_private_event();
		}
		
		//set up the form
		$private_event_rules = $this->events_m->rules;
		$this->form_validation->set_rules($private_event_rules);
		
		//process the form
		if($this->form_validation->run()==TRUE){
			$data['name'] = $this->input->post('private_event_name');
			$data['description'] = $this->input->post('private_event_description');
			$data['typeId'] = '';
			$data['datetime'] = $this->input->post('private_event_date');
			$data['venueId'] = '';
			$data['stubhub_url'] = '';
			$data['insertedon'] = '';
			$data['insertedby'] = $user->email;
			$data['updatedon'] = '';
			$data['updatedby'] = '';
			$this->events_m->save($data,$id);
			redirect($this->get_user_identifier() . '/dashboard/events');
		}
		
		//load view
		$this->data['subview']=$this->get_user_identifier().'/dashboard/private_event_form';
		$this->load->view($this->get_user_identifier().'/_layout_modal',$this->data);
	}

}