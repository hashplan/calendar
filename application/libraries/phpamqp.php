<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . 'libraries/phpamqp/autoload.php');

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Phpamqp
{
    private $CI = null;


    public function __construct($config = array())
    {
        $this->CI = & get_instance();

    }

    protected function get_connection(){
        /*$this->CI->config->load('amqp', TRUE);

        $connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();*/
    }

}