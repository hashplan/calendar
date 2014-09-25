<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Venues extends AdminController {

    public	function __construct(){
        parent::__construct();
        $this->load->model(array('venues_m', 'cities_m', 'states_m'));
    }

    public function index($page = 1, $limit = 50, $sort = 'city', $sort_type = 'ASC')
    {
        $this->venues_list($page, $limit, $sort, $sort_type);
    }
    
    public function get_venues_list(){
        if($this->input->is_ajax_request()){
            $this->load->model('venues_m');
            $post = $this->input->post();
            $options = array();
            if (!empty($post['metro_id'])) $options['metroarea'] = $post['metro_id'];
            $venues = $this->venues_m->get_venues($options);
            $venues_list = array();
            foreach($venues as $venue){
                $venues_list[$venue->id] = $venue->venue_name;
            }
            header('Content-Type: application/json');
            echo json_encode($venues_list);
            die();
        }
    }
    
    public function venues_list($page = 1, $limit = 50)
    {
        Menu::setActive('admin/venues/venues_list');
        $page || $page = 1;
        $offset = $limit * $page - $limit;
        $counters = $this->get_counters();

        $paged = new stdClass();
        $paged->current_page = $page;
        $paged->total_pages = ceil($counters['venues_list'] / $limit);
        $paged->items_on_page = $limit;
        $paged->has_previous = $page > 1;
        $paged->previous_page = $paged->has_previous ? $page - 1 : $page;
        $paged->total_rows = $counters['venues_list'];
        $paged->has_next = $paged->total_pages > $page;
        $paged->next_page = $paged->has_next ? $page + 1 : $page;

        $this->data['pagination'] = $this->get_paging($paged, 'admin/venues/venues_list/');

        $options = array(
            'venues_type' => false,
            'offset' => $offset,
            'limit' => $limit,
            'sort_type' => 'ASC'
        );
        $this->data['venues'] = $this->venues_m->get_venues_list($options);
        $this->data['view'] = 'admin/venues/venues_list';
        $this->_render_page();
    }
    
    public function remove($venueId)
    {
        $this->venues_m->delete($venueId);
        redirect('admin/venues');
    }
    
    public function add($venueId = false)
    {
        $this->form_validation->set_rules('name', 'Venue name', 'trim|required|xss_clean')
                              ->set_rules('address', 'Venue Address', 'trim|required|xss_clean')
                              ->set_rules('zip', 'Zip/Postal Code', 'trim');
        
        $this->form_validation->set_rules('cityId', 'City', 'trim|required|xss_clean');
        $this->form_validation->set_rules('stateId', 'State', 'trim|required|xss_clean');
        $this->form_validation->set_rules('description', 'Description', 'trim|xss_clean');
        $this->form_validation->set_rules('phone', 'Venue Phone', 'trim|xss_clean');
        $this->form_validation->set_rules('website', 'Venue Website', 'trim|xss_clean');
        if ($post = $this->input->post())
        {
            if ($this->form_validation->run()) {
                $post['insertedby'] = $this->get_user()->id;
                $post['updatedon'] = date('Y-m-d H:i:s');
                $post['venue_id'] = isset($venueId) && !empty($venueId)?$venueId:0;

                $saveData = array(
                    'name'=>$post['name'],
                    'address'=>$post['address'],
                    'cityId'=>$post['cityId'],
                    'city'=>$this->cities_m->getCityNameById($post['cityId']),
                    'stateId'=>$post['stateId'],
                    'zip'=>$post['zip'],
                    'phone'=>$post['phone'],
                    'website'=>$post['website'],
                    'description'=>$post['description'],
                    'updatedon'=>date('Y-m-d H:i:s'),
                  
                );
                if (!$venueId) {
                    $saveData['insertedby'] = date('Y-m-d H:i:s');
                }
                $this->venues_m->save($saveData, $venueId);
                $this->update_counters(true);
                redirect('admin/venues');
            } else {
                $this->data['venue'] = new  stdClass();
                $this->data['venue']->country_id = $post['country_id'];
                $this->data['venue']->stateId = isset($post['stateId']) && !empty($post['stateId'])?$post['stateId']:'rfff';
                $this->data['venue']->cityId = isset($post['cityId']) && !empty($post['cityId'])?$post['cityId']:'ffffhhhhh';
                $this->data['venue']->venue_name = isset($post['venue_name']) && !empty($post['venue_name']) ? $post['venue_name'] : '';
                $this->data['venue']->venue_address = isset($post['venue_address']) && !empty($post['venue_address']) ? $post['venue_address'] : '';
                $this->data['venue']->description = isset($post['description']) && !empty($post['description']) ? $post['description'] : '';
                $this->data['venue']->phone = isset($post['phone']) && !empty($post['phone']) ? $post['phone'] : '';
                $this->data['venue']->website = isset($post['website']) && !empty($post['website']) ? $post['website'] : '';
            }
        }
        if (empty($venueId))
        {
            Menu::setActive('admin/venues/add');
            $this->data['title'] = 'Create New Venue';
            $this->data['save_button_name'] = 'Create';
            $country_id = isset($post['country_selected']) && !empty($post['country_selected']) ? $post['country_selected'] : 0;
        }
        else {
            Menu::setActive('admin/venues/edit');
            if (!isset($this->data['venue'])) {
                $this->data['venue'] = $this->venues_m->get_venue_by_id($venueId);
            }

            $country_id = isset($post['country_selected']) && !empty($post['country_selected']) ? $post['country_selected'] : $this->data['venue']->country_id;

            if(empty($this->data['venue'])){
                show_404();
            }
            $this->data['title'] = 'Edit Venue';
            $this->data['save_button_name'] = 'Update';
            $this->data['venue_id'] = $venueId;
            
        }
        $this->data['country_id'] = $country_id;
        $options = array(
          'country_id' => $country_id
        );
        $this->load->model('location_m');
        $this->data['states'] = $this->location_m->get_states($options);
        
        $countries = $this->location_m->get_countries();
        $this->data['countries'][''] = 'Select Country';
        foreach ($countries as $country) {
            $this->data['countries'][$country->id] = $country->country;
        }
        $this->data['view'] = 'admin/venues/add';
       
        $js_assets = array(
            array('admin/create_new_venue.js')
        );
        $this->carabiner->group('page_assets', array('js' => $js_assets));

        $this->_render_page();
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
        $html = form_dropdown('stateId', $statesArr, $stateId, 'id="state_id" class="metro_area btn"');

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

        $html = form_dropdown('cityId', $cities, $cityId, 'id="city_id" class="metro_area btn"');

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

    public function switch_excluded($venueId, $status = 0){
        $this->venues_m->switch_excluded($venueId, $status);
        redirect('admin/venues');
    }

    public function switch_is_sticky($venueId, $status = 0){
        $this->venues_m->switch_is_sticky($venueId, $status);
        redirect('admin/venues');
    }
}