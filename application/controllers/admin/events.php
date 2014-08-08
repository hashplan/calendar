<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Events extends AdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('events_m');
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
        $this->data['view'] = 'admin/events/add';

        $this->_render_page();
    }


}