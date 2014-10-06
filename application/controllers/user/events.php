<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Events extends AuthController
{

    protected $allowTypes = array('deleted', 'favourite', 'my', 'friends', 'all', 'trash');
    protected $typesView = array(
        'my' => 'profile',
        'favourite' => 'profile',
        'all' => 'index',
        'deleted' => 'profile',
        'trash' => 'profile',
        'friends' => 'friend_plans',
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->model('events_m');
        $this->load->model('users_m');

        $this->data['user']->metro = $this->users_m->get_user_metro($this->get_user()->id);
        $this->data['sub_layout'] = 'layouts/user_page';

        $js_assets = array(
            array('event_search.js'),
            array('user_added_event_form.js'),
            array('event_modal.js'),
        );
        $css_assets = array(
            array('event.css'),
            array('event_modal.css'),
        );
        $this->carabiner->group('page_assets', array('js' => $js_assets, 'css' => $css_assets));
    }

    public function index()
    {
        $this->all();
    }

    public function my()
    {
        Menu::setActive('user/events/my');
        $this->_render_events_list_page('my', 'All my events');
    }

    public function friends($user_id)
    {
        if (!$this->users_m->is_friend_of($user_id)) {
            show_404();
        }
        $this->data['user'] = $this->ion_auth->user($user_id)->row();
        $fullname = $this->data['user']->first_name . " " . $this->data['user']->last_name;
        $fullname = trim($fullname);
        $this->_render_events_list_page('friends', $fullname . ' Events', $user_id);
    }

    public function all()
    {
        Menu::setActive('user/events/all');
        $default_location = $this->get_user()->metro;
        $this->_render_events_list_page('all', isset($default_location->city) ? 'Events in ' . $default_location->city : '', NULL, $default_location);
    }

    public function trash()
    {
        $this->_render_events_list_page('deleted', 'All deleted events');
    }

    public function favourite()
    {
        $this->_render_events_list_page('favourite', 'All favourite events');
    }

    public function events_list()
    {
        if(!$this->input->is_ajax_request())
        {
            show_404();
        }
        $post = $this->input->post();
        $options = array();
        if (!empty($post['category']) && $post['category'] != 0) $options['category'] = $post['category'];
        if (!empty($post['preselects']) && ($post['preselects'] === 'weekend' || $post['preselects'] != 0)) $options['preselects'] = $post['preselects'];
        if (!empty($post['offset'])) $options['offset'] = $post['offset'];
        if (!empty($post['metro_id'])) $options['metro_id'] = $post['metro_id'];
        if (!empty($post['name']) && strlen(trim($post['name']))) $options['name'] = trim($post['name']);
        if (!empty($post['specific_date'])) $options['specific_date'] = $post['specific_date'];
        if (!empty($post['venue_id'])) $options['venue_id'] = $post['venue_id'];
        if (!empty($post['user_id'])) $options['user_id'] = $post['user_id'];
        if (!empty($post['events_type']) && in_array($post['events_type'], $this->allowTypes)) {
            $options['events_type'] = $post['events_type'];
        }
        else {
            $options['events_type'] = 'all';
        }
        $current_date = !empty($post['current_date']) ? $post['current_date'] : NULL;
        $events_data = array(
            'events' => $this->events_m->get_all($options),
            'current_date' => $current_date,
            'user_id' => $options['user_id'] ? $options['user_id'] : $this->ion_auth->user()->row()->id
        );
        $this->load->view('user/events/events_' . $options['events_type'], $events_data);

    }

    public function choose_metro()
    {
        $this->load->model('location_m');
        $this->load->view('/event/metros', array('metros' => $this->location_m->get_event_metro_areas(), 'hide_events' => FALSE));
    }

    protected function _render_events_list_page($events_type, $page_title, $user_id = NULL, $default_location = NULL)
    {

        $this->load->model('categories_m');
        $this->data['page_class'] = 'user-events';
        $this->data['view'] = 'user/events/' . $this->typesView[$events_type];
        $this->data['user_id'] = $this->users_m->user_id_is_correct($user_id) ? $user_id : $this->get_user()->id;

        $events_search_params = array('events_type' => $events_type, 'user_id' => $user_id);
        $top_venues_params = array();
        if ($default_location !== NULL) {
            $top_venues_params['metroarea'] = $events_search_params['metro_id'] = $this->data['metro_id'] = isset($default_location->metroId) ? $default_location->metroId : '';
            $this->data['metro_name'] = isset($default_location->city) ? $default_location->city : '';
            $this->data['picture_path'] = 'assets/img/metroareas/'. (isset($default_location->picture_path) ? $default_location->picture_path : 'default.jpg');
        }
        else{
            $this->data['picture_path'] = 'assets/img/metroareas/default.jpg';
        }

        $this->load->model('venues_m');
        $sticky_venues = $this->venues_m->get_sticky_venues($top_venues_params);
        $top_venues = $this->venues_m->get_top_venues($top_venues_params);
        $this->data['data']['top_venues'] = $this->load->view('user/events/top_venues_list', array('sticky_venues' => $sticky_venues, 'top_venues' => $top_venues), true);

        $events = $this->events_m->get_all($events_search_params);
        $events_data = array(
            'events' => $events,
            'categories' => $this->categories_m->get_top_level_categories(),
            'current_date' => NULL,
            'user_id' => $this->data['user_id']
        );
        $this->data['data']['events'] = $this->load->view('user/events/events_' . $events_type, $events_data, true);
        $this->data['data']['has_events'] = count($events) > 0;
        $this->data['data']['events_type'] = $events_type;
        $this->data['data']['page_title'] = $page_title;

        $this->_render_page();
    }

    public function top_venues_list()
    {
        $this->load->model('venues_m');
        $post = $this->input->post();
        $options = array();
        if (!empty($post['metro_id'])) $options['metroarea'] = $post['metro_id'];
        $sticky_venues = $this->venues_m->get_sticky_venues($options);
        $top_venues = $this->venues_m->get_top_venues($options);
        $this->load->view('user/events/top_venues_list', array('sticky_venues' => $sticky_venues, 'top_venues' => $top_venues));
    }

}