<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crawler extends AdminController {

    public	function __construct(){
        parent::__construct();
        $this->load->library('event_crawler');
    }

    public function index(){
        $this->data['view'] = 'admin/crawler/index';
        $this->_render_page();
    }

    public function run(){
        $this->event_crawler->start_parse();
        redirect('admin/crawler');
    }
    
    public function update_venues_addresses(){

        $this->event_crawler->update_venues_addresses();
        redirect('admin/crawler');
    }
}