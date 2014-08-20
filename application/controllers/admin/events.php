<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Events extends AdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('events_m');

        $css_assets = array(
            array('admin/events.css')
        );
        $this->carabiner->group('page_assets', array('css' => $css_assets));

    }

    public function index($page = 1, $limit = 50)
    {
        $this->future($page, $limit);

    }

    public function future($page = 1, $limit = 50)
    {
        Menu::setActive('admin/events/future');
        $page || $page = 1;
        $offset = $limit * $page - $limit;
        $counters = $this->get_counters();

        $paged = new stdClass();
        $paged->current_page = $page;
        $paged->total_pages = ceil($counters['future_events'] / $limit);
        $paged->items_on_page = $limit;
        $paged->has_previous = $page > 1;
        $paged->previous_page = $paged->has_previous ? $page - 1 : $page;
        $paged->total_rows = $counters['future_events'];
        $paged->has_next = $paged->total_pages > $page;
        $paged->next_page = $paged->has_next ? $page + 1 : $page;

        $this->data['pagination'] = $this->get_paging($paged, 'admin/events/');

        $options = array(
            'events_type' => 'future_events',
            'offset' => $offset,
            'limit' => $limit,
            'sort_type' => 'DESC'
        );
        $this->data['events'] = $this->events_m->list_of_events($options);
        $this->data['view'] = 'admin/events/future_events';
        $this->_render_page();
    }

    public function custom($page = 1, $limit = 50)
    {
        Menu::setActive('admin/events/custom');
        $page || $page = 1;
        $offset = $limit * $page - $limit;
        $counters = $this->get_counters();

        $paged = new stdClass();
        $paged->current_page = $page;
        $paged->total_pages = ceil($counters['custom_future_events'] / $limit);
        $paged->items_on_page = $limit;
        $paged->has_previous = $page > 1;
        $paged->previous_page = $paged->has_previous ? $page - 1 : $page;
        $paged->total_rows = $counters['custom_future_events'];
        $paged->has_next = $paged->total_pages > $page;
        $paged->next_page = $paged->has_next ? $page + 1 : $page;

        $this->data['pagination'] = $this->get_paging($paged, 'admin/events/custom');

        $options = array(
            'events_type' => 'custom_future_events',
            'offset' => $offset,
            'limit' => $limit
        );
        $this->data['events'] = $this->events_m->list_of_events($options);
        $this->data['view'] = 'admin/events/custom_future_events';
        $this->_render_page();
    }

    public function add($event_id = false)
    {
        $this->form_validation->set_rules('name', 'Event name', 'trim|required|xss_clean')
                              ->set_rules('description', 'Event Description', 'trim|required|xss_clean')
                              ->set_rules('date', 'Event Date', 'required')
                              ->set_rules('venue_id', 'Venue', 'required')
                              ->set_rules('time', 'Event Time', 'required');
        $post = $this->input->post();

        if (isset($post['new_venue']) && !empty($post['new_venue']))
        {

            $this->form_validation->set_rules('venue_city_id', 'City', 'trim|required|xss_clean');
            $this->form_validation->set_rules('venue_state_id', 'State', 'trim|required|xss_clean');
            $this->form_validation->set_rules('country_id', 'Country', 'trim|required|xss_clean');
            $this->form_validation->set_rules('venue_address', 'Venue Address', 'trim|required|xss_clean');
            $this->form_validation->set_rules('venue_name', 'Venue Name', 'trim|required|xss_clean');
        }
        else
        {
            
        }
        if ($this->form_validation->run()) {
            $post['insert_by'] = $this->get_user()->id;
            $post['event_id'] = $event_id;

            $this->load->model('events_m');
            $this->events_m->save($post);
            $this->update_counters(true);
            $post['new_venue'] = isset($post['new_venue']) && !empty($post['new_venue'])?$post['new_venue']:false;
            redirect('admin/events');
        } else {
            $this->data['country_id'] = $post['country_id'];
            $this->data['venue_state_id'] = isset($post['venue_state_id']) && !empty($post['venue_state_id'])?$post['venue_state_id']:'';
            $this->data['venue_city_id'] = isset($post['venue_city_id']) && !empty($post['venue_city_id'])?$post['venue_city_id']:'';
            $this->data['venue_name'] = isset($post['venue_name']) && !empty($post['venue_name']) ? $post['venue_name'] : '';
            $this->data['venue_address'] = isset($post['venue_address']) && !empty($post['venue_address']) ? $post['venue_address'] : '';

        }
        $this->load->model('location_m');
        $this->load->model('venues_m');

        if (empty($event_id))
        {
            Menu::setActive('admin/events/add');
            $this->data['title'] = 'Create New Event';
            $this->data['save_button_name'] = 'Create';
            $country_id = isset($post['country_selected']) && !empty($post['country_selected']) ? $post['country_selected'] : 0;
        }
        else {
            Menu::setActive('admin/events/edit');
            $this->data['event'] = $this->events_m->get_event_by_id($event_id);
            $country_id = isset($post['country_selected']) && !empty($post['country_selected']) ? $post['country_selected'] : $this->data['event']->country_id;
            

            if(empty($this->data['event'])){
                show_404();
            }
            $this->data['event']->date = date('Y-m-d',strtotime($this->data['event']->event_datetime));
            $this->data['event']->time = date('H:i:s',strtotime($this->data['event']->event_datetime));
            $this->data['title'] = 'Edit Event';
            $this->data['save_button_name'] = 'Update';
            $this->data['event_id'] = $event_id;
            $this->data['country_id'] = $country_id;
        }
        $this->data['new_venue'] = isset($post['new_venue'])?$post['new_venue']:false;
        $options = array(
          'country_id' => $country_id
        );
        $this->data['states'] = $this->location_m->get_states($options);
        $countries = $this->location_m->get_countries();
        $this->data['countries'][''] = 'Select Country';
        foreach ($countries as $country) {
            $this->data['countries'][$country->id] = $country->country;
        }
        $this->data['view'] = 'admin/events/add';
        $this->data['metros'] = $this->location_m->get_all_metro_areas();
        $venues = $this->venues_m->get_venues();

        foreach ($venues as $venue)
        {
            $this->data['venues'][$venue->venue_id] = $venue->venue_name;
        }

        $js_assets = array(
            array('admin/create_new_event.js')
        );
        $this->carabiner->group('page_assets', array('js' => $js_assets));

        $this->_render_page();
    }

    public function remove($eventId)
    {
        $this->events_m->changeStatus($eventId, 'cancelled');
        redirect('admin/events');
    }

    public function getStates()
    {
        $countryId = $this->input->post('countryId');
        $stateId = $this->input->post('stateId');
        $this->load->model('location_m');
        $states = $this->location_m->get_states(array('country_id' => $countryId));
        $statesArr[''] = 'Select State';
        foreach ($states as $state) {
            $statesArr[$state->id] = $state->state;
        }
        $html = form_dropdown('venue_state_id', $statesArr, $stateId, 'id="state_id" class="metro_area btn"');

        $result = array('html' => $html);
        if($this->input->is_ajax_request()){
            header('Content-Type: application/json');
            echo json_encode($result);
            die();
        }
    }

    public function getCities()
    {
        $stateId = $this->input->post('stateId');
        $cityId = $this->input->post('cityId');
        $this->load->model('location_m');
        $cities = $this->location_m->getCities($stateId);

        $html = form_dropdown('venue_city_id', $cities, $cityId, 'id="city_id" class="metro_area btn"');

        $result = array('html' => $html);
        if($this->input->is_ajax_request()){
            header('Content-Type: application/json');
            echo json_encode($result);
            die();
        }
    }    

    public function getCountries()
    {
        $countryId = $this->input->post('countryId');
        $this->load->model('location_m');

        $countries = $this->location_m->get_countries();
        foreach ($countries as $country)
        {
            $contriesArr[$country->id] = $country->country;
        }

        $html = form_dropdown('country_id', $contriesArr, $countryId, 'id="country_id" class="metro_area btn"');

        $result = array('html' => $html);
        if($this->input->is_ajax_request()){
            header('Content-Type: application/json');
            echo json_encode($result);
            die();
        }
    }    
}