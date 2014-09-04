<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CronController
{

    function __construct()
    {
        parent::__construct();
    }

    public function index($period = null)
    {
        switch ($period) {
            case 'every_day':
                $this->_every_day();
                break;
            case 'every_two_hours':
                $this->_every_two_hours();
                break;
            case 'every_week':
                $this->_every_week();
                break;
        }
    }

    protected function _every_two_hours()
    {
        $this->load->library('event_crawler');
        $this->event_crawler->update_venues_addresses();
    }

    protected function _every_day()
    {

    }

    protected function _every_week()
    {
        $this->_crawler();
    }

    private function _crawler()
    {
        $this->load->library('event_crawler');
        $this->event_crawler->start_parse();
    }
}