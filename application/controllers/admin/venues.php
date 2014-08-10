<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Venues extends AdminController {

    public	function __construct(){
        parent::__construct();
        $this->load->model('venues_m');
    }

    public function index(){

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
}