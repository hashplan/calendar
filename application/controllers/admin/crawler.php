<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crawler extends AdminController {

    public	function __construct(){
        parent::__construct();
        $this->load->library('event_crawler');
    }

    public function index(){
        $this->event_crawler->start_parse('pollstar');
    }

}