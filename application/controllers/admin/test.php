<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Test extends AdminController
{
    //TODO: simply has been moved method from auth controller and views

    public function __construct()
    {
        parent::__construct();
    }

    public function index($type = '')
    {
        $this->layout = '_layout_email';
        $this->data['view'] = 'email/activate.tpl.php';
        $this->data['id'] = 123;
        $this->data['activation'] = '2j34hg32kuyg23k4tg32ug23g42g34uo5';
        $this->data['identity'] = 'Roma S';

        if($type == 'email'){
            $this->load->config('ion_auth', TRUE);

            $message = $this->load->view('email/activate.tpl.php', $this->data, true);

            $this->email->clear();
            $this->email->from('noreply@hashplans.com');
            $this->email->to('devdevdevdevdevdev727@gmail.com');
            $this->email->subject($this->config->item('site_title', 'ion_auth') . ' - ' . $this->lang->line('email_activation_subject'));
            $this->email->message($message);

            if ($this->email->send() == TRUE) {
                echo "<pre>";
                var_dump('has been sent');
                echo "</pre>";
                die(__FILE__ . ':' . __LINE__);
            }
            echo "<pre>";
            var_dump('ERROR');
            echo "</pre>";
            die(__FILE__ . ':' . __LINE__);
        }





        $this->_render_page();
    }


}