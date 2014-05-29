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

	public function delete($event_id = NULL) {
		$event_id_is_correct = $event_id !== NULL && is_numeric($event_id) && $event_id;
		if (!$event_id_is_correct) {
			return;
		}
		$this->load->model('events_m');
		$this->events_m->delete($event_id);
		redirect(base_url('user/dashboard'));
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