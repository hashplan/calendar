<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events extends AdminController {

    public	function __construct(){
        parent::__construct();
        $this->load->model('events_m');
    }

    public function index($page = 1, $limit = 50){
        $this->future($page, $limit);

    }

    public function future($page = 1, $limit = 50){
        $page || $page = 1;
        $offset = $limit * $page - $limit;
        $options = array(
            'events_type' => 'all',
            'offset' => $offset,
            'limit' => $limit
        );
        $this->data['events'] = $this->events_m->get_all($options);
        $this->data['view'] = 'admin/events/index';
        $this->_render_page();
    }

    public function custom($page = 1, $limit = 50){
        $page || $page = 1;
        $offset = $limit * $page - $limit;
        $options = array(
            'events_type' => 'all',
            'offset' => $offset,
            'limit' => $limit
        );
        $this->data['events'] = $this->events_m->get_all($options);
        $this->data['view'] = 'admin/events/index';
        $this->_render_page();
    }

    public function edit($userId){

    }

    public function add(){

    }


}