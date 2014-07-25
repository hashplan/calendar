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
            case 'every_week':
                $this->_every_week();
                break;
        }
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