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
        $paged->has_previous = $page - 1 > 0;
        $paged->previous_page = $paged->has_previous ? $page - 1 : $page;
        $paged->total_rows = $counters['future_events'];
        $paged->has_next = $paged->total_pages > $page;
        $paged->next_page = $paged->has_next ? $page + 1 : $page;

        $this->data['pagination'] = $this->get_paging($paged, 'admin/events/');

        $options = array(
            'events_type' => 'future_events',
            'offset' => $offset,
            'limit' => $limit
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
        $paged->has_previous = $page > 0;
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

    public function add()
    {
        $this->form_validation->set_rules('name', 'Event name', 'trim|required|xss_clean')
                              ->set_rules('description', 'Event Description', 'trim|required|xss_clean')
                              ->set_rules('date', 'Event Date', 'required')
                              ->set_rules('venue_id', 'Venue', 'required')
                              ->set_rules('time', 'Event Time', 'required');
        if ($this->form_validation->run()) {
            $post = $this->input->post();
            $post['insert_by'] = $this->get_user()->id;
            $this->load->model('events_m');
            $this->events_m->save($post);
            redirect('admin/events');
        }

        $this->load->model('location_m');
        $this->load->model('venues_m');
        Menu::setActive('admin/events/add');
        $this->data['view'] = 'admin/events/add';
        $this->data['metros'] = $this->location_m->get_all_metro_areas();
        $this->data['venues'] = $this->venues_m->get_venues();


        $js_assets = array(
            array('admin/create_new_event.js')
        );
        $this->carabiner->group('page_assets', array('js' => $js_assets));

        $this->_render_page();
    }


}