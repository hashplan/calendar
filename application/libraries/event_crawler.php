<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . 'libraries/crawler/autoload.php');

class Event_crawler
{

    private $drivers = array(
        'stubhub' => '_drv_stubhub',
        'pollstar' => '_drv_pollstar'
    );
    private $CI = null;

    public function __construct()
    {
        $this->CI = & get_instance();
    }

    public function start_parse($driver = null)
    {

        if (isset($this->drivers[$driver])) {
            $this->{$this->drivers[$driver]}();
        } else {
            if (!empty($this->drivers)) {
                foreach ($this->drivers as $driver) {
                    $this->{$driver}();
                }
            }
        }
    }

    private function _drv_stubhub()
    {
        $StubhubDrv = new StubhubDrv();
        $StubhubDrv->start();
    }

    private function _drv_pollstar()
    {
        $PollstarDrv = new PollstarDrv();
        $PollstarDrv->start();
    }


}