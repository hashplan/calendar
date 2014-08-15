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

    public function edit($id)
    {

    }

    public function add($event_id = false)
    {
        $this->form_validation->set_rules('name', 'Event name', 'trim|required|xss_clean')
                              ->set_rules('description', 'Event Description', 'trim|required|xss_clean')
                              ->set_rules('date', 'Event Date', 'required')
                              ->set_rules('venue_id', 'Venue', 'required')
                              ->set_rules('time', 'Event Time', 'required');
        if ($this->form_validation->run()) {
            $post = $this->input->post();
            $post['insert_by'] = $this->get_user()->id;
            $post['event_id'] = $event_id;
            $this->load->model('events_m');
            $this->events_m->save($post);
            $this->update_counters(true);
            redirect('admin/events');
        }

        $this->load->model('location_m');
        $this->load->model('venues_m');
        
        if (empty($event_id))
        {
            Menu::setActive('admin/events/add');
            $this->data['title'] = 'Create New Event';
            $this->data['save_button_name'] = 'Create';
        }
        else {
            Menu::setActive('admin/events/edit');
            $this->data = array_merge($this->data, $this->getDataFromDb($event_id));
            $this->data['title'] = 'Edit Event';
            $this->data['save_button_name'] = 'Update';
            $this->data['event_id'] = $event_id;
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

    private function getDataFromDb($eventID) {
        $data = $this->events_m->get_event_by_id($eventID);
           $dbData = array(
            'name' => $data->event_name,
            'vanue_id' => $data->venue_id,
            'description' => $data->event_description,
            'typeId' => $data->event_typeId,
            'datetime' => $data->event_datetime,
            'date' => date('Y-m-d',strtotime($data->event_datetime)),
            'time' => date('H:i:s',strtotime($data->event_datetime)),
            'venue_id' => $data->venue_id,
            'booking_link' => $data->event_booking_link,
            'insertedon' => $data->event_insertedon,
            'insertedby' => $data->event_insertedby,
            'updatedon' => $data->event_updatedon,
            'updatedby' => $data->event_updatedby,
            'is_public' => $data->event_is_public,
            'ownerId' => $data->event_owner_id,
            'status' => $data->event_status
        );

           return $dbData;
    }

    public function remove($eventId)
    {
        $res = $this->events_m->changeStatus($eventId, 'cancelled');
        var_dump($res);die("333333");
        redirect('admin/events');
    }
}