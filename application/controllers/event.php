<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Event extends AuthController
{

    public function __construct()
    {
        parent::__construct();
        $this->data['user'] = $this->ion_auth->user()->row();
    }

    public function add_to_favourites($event_id = NULL)
    {
        $event_id_is_correct = $event_id !== NULL && is_numeric($event_id) && $event_id;
        if (!$event_id_is_correct) {
            return;
        }
        $this->load->model('events_m');
        $this->events_m->add_to_favourites($event_id);
        redirect(base_url('user/events/favourite'));
    }

    public function delete_from_favourites($event_id)
    {
        $event_id_is_correct = $event_id !== NULL && is_numeric($event_id) && $event_id;
        if (!$event_id_is_correct) {
            return;
        }
        $this->load->model('events_m');
        $this->events_m->delete_from_favourites($event_id);
        redirect(base_url('user/events/favourite'));
    }

    public function delete_from_user_list($event_id = NULL)
    {
        $event_id_is_correct = $event_id !== NULL && is_numeric($event_id) && $event_id;
        if (!$event_id_is_correct) {
            return;
        }
        $this->load->model('events_m');
        $this->events_m->delete($event_id);
        redirect(base_url('user/events/all'));
    }

    public function restore_from_trash($event_id = NULL)
    {
        $event_id_is_correct = $event_id !== NULL && is_numeric($event_id) && $event_id;
        if (!$event_id_is_correct) {
            return;
        }
        $this->load->model('events_m');
        $this->events_m->restore_from_trash($event_id);
        redirect(base_url('user/events/trash'));
    }

    public function add_to_calendar($event_id = NULL)
    {
        $event_id_is_correct = $event_id !== NULL && is_numeric($event_id) && $event_id;
        if (!$event_id_is_correct) {
            return;
        }
        $this->load->model('events_m');
        $this->events_m->add_to_calendar($event_id);
        redirect(base_url('user/events'));
    }

    public function delete_from_calendar($event_id)
    {
        $event_id_is_correct = $event_id !== NULL && is_numeric($event_id) && $event_id;
        if (!$event_id_is_correct) {
            return;
        }
        $this->load->model('events_m');
        $this->events_m->delete_from_calendar($event_id);
        redirect(base_url('user/events'));
    }

    // should rename it later to smth like add_event or add_user_event
    public function add()
    {
        $this->load->model('location_m');
        $this->data['metros'] = $this->location_m->get_all_metro_areas();
        $this->load->view('event/add', $this->data);
    }

    public function save()
    {
        $this->load->model('location_m');

        //set up the form
        $this->form_validation->set_rules('name', 'Event Name', 'trim|required|xss_clean')
            ->set_rules('address', 'Event Address', 'trim|required|xss_clean|callback_check_address')
            ->set_rules('location', 'Event Location', 'trim|required|xss_clean')
            ->set_rules('date', 'Event Date', 'required')
            ->set_rules('time', 'Event Time', 'required')
            ->set_rules('description', 'Event Description', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE && $this->input->is_ajax_request()) {
            $response = array(
                'errors' => validation_errors()
            );
            header('Content-Type: application/json');
            echo json_encode($response);
            die();
        } else {
            $post = $this->input->post();
            $geo_data = $this->get_geocode($post['address']);
            if ($geo_data) {
                $post['city'] = $this->location_m->get_city_by_name($geo_data);
            } else {
                $post['city'] = null;
            }

            $this->load->model('events_m');
            $this->events_m->save($post);
            redirect('user/events/my');
        }
    }

    public function modal_details($event_id)
    {
        $this->load->model('events_m');
        $this->load->model('users_m');
        $event = $this->events_m->get_event_by_id($event_id);
        if (empty($event)) {
            show_404();
        }

        $this->data['event'] = $event;
        $this->data['google_maps_embed_api_key'] = $this->config->item('google_maps_embed_api_key');
        $this->data['is_my'] = $event->event_owner_id == $this->ion_auth->user()->row()->id;
        $this->data['is_favourite'] = count($this->events_m->get_favourite_events($event->event_id)) === 1;
        $this->data['in_calendar'] = count($this->events_m->get_calendar_events($event->event_id)) === 1;

        $this->data['friends_related_with_event'] = $this->users_m->get_friends_related_with_event($event_id);
        //$this->data['friends_you_can_invite_on_event'] = $this->users_m->get_friends_you_can_invite_on_event(array('event_id' => $event_id , 'limit' => 6));
        $this->load->view('event/index', $this->data);
    }

    public function yelp()
    {
        $this->load->library('Yelp_oauth');
        $term = $this->input->post('venue', NULL);
        $location = $this->input->post('city', NULL);
        if ($term && $location) {
            $raw_data = $this->yelp_oauth->search_request($term, $location);
            if (substr($raw_data, -2) === '[]') {
                $raw_data = substr($raw_data, 0, strlen($raw_data) - 2);
            }
            if (($data = json_decode($raw_data, TRUE)) && json_last_error() === JSON_ERROR_NONE) {
                if (isset($data['businesses'][0])) {
                    $business = $data['businesses'][0];
                    echo $this->load->view('event/yelp', array('business' => $business));
                } else {
                    echo 'No data from yelp';
                }
            }
        }

        echo '';
    }

    public function invite_friends_autocomplete()
    {
        if($this->input->is_ajax_request()){
            $this->form_validation
                ->set_rules('name','name','required')
                ->set_rules('event_id','event_id','required');

            if($this->form_validation->run() == TRUE){
                $post = $this->input->post();
                $exclude_ids = empty($post['exclude_ids']) ? array() : $post['exclude_ids'];

                $this->load->model('users_m');
                $options = array(
                    'name' => $post['name'],
                    'event_id' => $post['event_id'],
                    'exclude_ids' => $exclude_ids,
                );

                $friends = $this->users_m->get_friends_you_can_invite_on_event($options);
                header('Content-Type: application/json');
                echo json_encode($friends);
                die();
            }
        }

        header('Content-Type: application/json');
        echo json_encode(array());
        die();
    }

    public function send_invite()
    {
        if ($this->input->is_ajax_request()) {
            $this->form_validation
                ->set_rules('uid', 'uid', 'required')
                ->set_rules('event_id', 'event_id', 'required');

            if ($this->form_validation->run() == TRUE) {
                $this->load->model('users_m');
                $this->load->model('events_m');
                $this->events_m->add_to_calendar($this->input->post('event_id'));
                if ($this->users_m->set_connection_between_users($this->input->post('uid'), NULL, NULL, 'event_invite', $this->input->post('event_id'))) {
                    $this->load->library('hashplans_mailer');
                    $event = $this->events_m->get_event_by_id($this->input->post('event_id'));
                    $to_user = $this->ion_auth->user($this->input->post('uid'))->row();
                    $this->hashplans_mailer->send_event_invite_email($this->user, $to_user, $event);
                    header('Content-Type: application/json');
                    echo json_encode(array('result' => 'success'));
                }
            }
            else {
                header('Content-Type: application/json');
                echo json_encode(array('result' => 'error', 'error' => validation_errors()));
            }
        }
        die();
    }

    protected function get_geocode($address)
    {
        $result = false;
        $this->config->load('google_maps', TRUE);
        $api_key = $this->config->item('google_maps_embed_api_key', 'google_maps');
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($address) . "&key=" . $api_key;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $geoloc = json_decode(curl_exec($ch), true);
        if (isset($geoloc['status']) && $geoloc['status'] == 'OK') {
            if ($geoloc && !empty($geoloc['results'][0])) {
                foreach ($geoloc['results'][0]['address_components'] as $item) {
                    if ($item['types'][0] == 'locality') {
                        $result = $item['long_name'];
                    }
                }
            }
        }
        return $result;
    }

    public function check_address($address)
    {
        $result = $this->get_geocode($address);

        if (!$result) {
            $this->form_validation->set_message('check_address', 'Wrong %s field.');
            return FALSE;
        }
        if ($result && $city = $this->location_m->get_city_by_name($result)) {
            if ($city->metroId != $this->input->post('location')) {
                $metro = $this->db->where(array('id' => $city->metroId))->get('metroareas')->row();
                $this->form_validation->set_message('check_address', 'Wrong Event Address or Location fields. Location should be ' . $metro->city . ' or input another Address.');
                return FALSE;
            }
        }
        return TRUE;
    }
}