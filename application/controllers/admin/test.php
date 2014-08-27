<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'libraries/crawler/autoload.php');
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
        $this->data['view'] = 'email/friend_invite.tpl.php';
        $this->data['id'] = 123123;
        $this->data['activation'] = 'test$test$test$test$test$test$test$';
        $this->data['identity'] = 'User';

        $this->data['password'] = 'autopassword';

        $this->data['user_name'] = 'test user name';
        $this->data['user_email'] = 'test@test.test';
        $this->data['contact_description'] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc non auctor mi, sit amet egestas lacus. Nulla ultrices sodales leo, sit amet consequat lectus lacinia ut. Mauris ac interdum urna. Donec dignissim, turpis ac tincidunt interdum, lectus orci ultricies tellus, a sodales leo mi sed felis. Mauris tincidunt facilisis ornare. Curabitur a sapien ut nisl eleifend bibendum ut quis mauris. Nunc et arcu fermentum, pharetra neque ut, tincidunt nisi. Suspendisse feugiat accumsan nulla eu accumsan. Sed id molestie mi, pharetra vehicula risus.';

        $this->data['from_name'] = 'YOUR FRIEND';
        $this->data['event_name'] = 'SUPER MEGA EVENT';

        $this->data['forgotten_password_code'] = 'test$test$test$test$test$test$test$';

        $this->data['new_password'] = 'test$test$test$test$test$test$test$';

        if($type == 'email'){
            $this->load->config('ion_auth', TRUE);

            $message = $this->load->view('email/event_invite.tpl.php', $this->data, true);

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

    
    public function scrapUrl($city)
    {
        $StubhubDrv = new StubhubDrv();
        $StubhubDrv->scrap_test($city);
        
    }
}