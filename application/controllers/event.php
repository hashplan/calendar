<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Event extends MY_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->ion_auth->in_group("members")){
			redirect('auth/login','refresh');
		}
		$this->data['user'] = $this->ion_auth->user()->row();
	}

	public function add_to_favourites($event_id = NULL) {
		$event_id_is_correct = $event_id !== NULL && is_numeric($event_id) && $event_id;
		if (!$event_id_is_correct) {
			return;
		}
		$this->load->model('events_m');
		$this->events_m->add_to_favourites($event_id);
	}

	public function delete_from_user_list($event_id = NULL) {
		$event_id_is_correct = $event_id !== NULL && is_numeric($event_id) && $event_id;
		if (!$event_id_is_correct) {
			return;
		}
		$this->load->model('events_m');
		$this->events_m->delete($event_id);
		redirect(base_url('user/events'));
	}

	public function restore_from_trash($event_id = NULL) {
		$event_id_is_correct = $event_id !== NULL && is_numeric($event_id) && $event_id;
		if (!$event_id_is_correct) {
			return;
		}
		$this->load->model('events_m');
		$this->events_m->restore_from_trash($event_id);
		redirect(base_url('user/events/trash'));
	}

	public function add_to_calendar($event_id = NULL) {
		$event_id_is_correct = $event_id !== NULL && is_numeric($event_id) && $event_id;
		if (!$event_id_is_correct) {
			return;
		}
		$this->load->model('events_m');
		$this->events_m->add_to_calendar($event_id);
		redirect(base_url('user/events'));
	}

	// should rename it later to smth like add_event or add_user_event
	public function add($id = NULL){
		//retrieve an event or set a new one
		if($id){
			$this->data['user_added_event'] = $this->events_m->get_event_by_id($id);
			count($this->data['user_added_event'])||$this->data['errors'][]='Event could not be found';
		}
		else {
			$this->data['user_added_event'] = $this->events_m->get_new_user_added_event();
		}

		//set up the form
		$this->form_validation->set_rules('user_added_event_name', 'Event Name','trim|required|xss_clean');
		$this->form_validation->set_rules('user_added_event_address', 'Event Address','trim|required|xss_clean');
		$this->form_validation->set_rules('user_added_event_location', 'Event Location','trim|required|xss_clean');
		$this->form_validation->set_rules('user_added_event_date', 'Event Date','required');
		$this->form_validation->set_rules('user_added_event_time', 'Event Time','required');
		$this->form_validation->set_rules('user_added_event_description', 'Event Description','trim|required|xss_clean');

		//process the form
		if($this->form_validation->run()==TRUE){
			$data['form_post'] = $this->events_m->array_from_post(array( //array_from_post set in core/my_model
				'user_added_event_name',
				'user_added_event_address',
				'user_added_event_location',
				'user_added_event_date',
				'user_added_event_time',
				'user_added_event_description'
			));

			$data['table_name'] = 'user_added_event';
			$data['insertedby'] = $user_id = $this->ion_auth->user()->row()->id;
			$this->events_m->save_user_added_event($data,$id);
			redirect($this->get_user_identifier() . '/dashboard/events');
		}

		//load view
		$this->data['subview']=$this->get_user_identifier().'/dashboard/user_added_event_form';
		$this->load->view($this->get_user_identifier().'/_layout_modal',$this->data);
	}

	public function modal_details($event_id) {
		$this->load->model('events_m');
		$event = $this->events_m->get_event_by_id($event_id);
		$this->data['event'] = $event;
		$this->data['google_maps_embed_api_key'] = $this->config->item('google_maps_embed_api_key');
		$this->data['is_favourite'] = count($this->events_m->get_favourite_events($event->event_id)) === 1;
		$this->load->view('event/index', $this->data);
	}

	public function yelp() {
		$this->load->library('Yelp_oauth');
		$term = $this->input->post('venue', NULL);
		$location = $this->input->post('city', NULL);
		if ($term && $location) {
			$raw_data = $this->yelp_oauth->search_request($term, $location);
			if (substr($raw_data, -2) === '[]') {
				$raw_data = substr($raw_data, 0, strlen($data) - 2);
			}
			if (($data = json_decode($raw_data, TRUE)) && json_last_error() === JSON_ERROR_NONE) {
				$business = $data['businesses'][0];
				echo $this->load->view('event/yelp', array('business' => $business));
			}
		}

		echo '';
	}
}