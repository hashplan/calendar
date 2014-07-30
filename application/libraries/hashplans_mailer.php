<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Hashplans_mailer{

    protected $layout = '_layout_email';
    protected $data = array(
        'subject' => 'Hashplans Notification',
        'from_email' => 'noreply@hashplans.com',
        'from_name' => 'Hashplans',
        'data' => array()
    );
    protected $CI;

    public function __construct(){
        $this->CI = &get_instance();
        $this->CI->load->library('email');
        $this->CI->config->load('email');
        $this->CI->email->set_newline("\r\n");
        $this->data['from_email'] = $this->CI->config->item('from_email');
    }

    //send to invited
    public function send_friend_invite_email($from, $to){
        $this->data['view'] = 'email/friend_invite.tpl.php';
        $this->data['subject'] = 'Friendship request';
        $this->data['to'] = $to->email;
        $this->data['data']['from_name'] = $this->_generate_full_name($from);
        $this->_send();
    }

    //send back to inviter
    public function send_friend_confirmed_email($from, $to){
        $this->data['view'] = 'email/friend_confirmed.tpl.php';
        $this->data['subject'] = 'Friendship request';
        $this->data['to'] = $to->email;
        $this->data['data']['from_name'] = $this->_generate_full_name($from);
        $this->_send();
    }

    //send back to inviter
    public function send_friend_refused_email(){
        $this->data['view'] = 'email/friend_refused.tpl.php';

    }

    //send to invited
    public function send_event_invite_email($from, $to, $event){
        $this->data['view'] = 'email/event_invite.tpl.php';
        $this->data['subject'] = 'Invitation to Event';
        $this->data['to'] = $to->email;
        $this->data['data']['from_name'] = $this->_generate_full_name($from);
        $this->data['data']['event_name'] = $event->event_name;
        $this->_send();
    }

    //send back to inviter
    public function send_event_confirmed_email($from, $to, $event){
        $this->data['view'] = 'email/event_confirmed.tpl.php';
        $this->data['subject'] = 'Invitation to Event has been Accepted';
        $this->data['to'] = $to->email;
        $this->data['data']['from_name'] = $this->_generate_full_name($from);
        $this->data['data']['event_name'] = $event->event_name;
        $this->_send();
    }

    //send back to inviter
    public function send_event_refused_email($from, $to, $event){
        $this->data['view'] = 'email/event_refused.tpl.php';
        $this->data['subject'] = 'Invitation to Event has been declined';
        $this->data['to'] = $to->email;
        $this->data['data']['from_name'] = $this->_generate_full_name($from);
        $this->data['data']['event_name'] = $event->event_name;
        $this->_send();
    }

    public function send_contact_us_form_email($data){
        $this->data['view'] = 'email/contact_us.tpl.php';
        $this->data['subject'] = 'Contact Us';
        $this->data['to'] = $this->CI->config->item('contact_form_email');
        $this->data['from_name'] = 'Hashplans Contact Form';
        $this->data['data'] = $data;
        $this->_send();
    }

    protected function _render(){
        $message = $this->CI->load->view($this->layout, $this->data, TRUE);
        $this->CI->email->subject($this->data['subject']);
        $this->CI->email->from($this->data['from_email'], $this->data['from_name']);
        $this->CI->email->to($this->data['to']);
        $this->CI->email->message($message);
    }

    protected function _send(){
        $this->CI->email->clear();
        $this->_render();
        if(!$this->CI->email->send()){
            print_r($this->CI->email->print_debugger());
            error_log('error', $this->CI->email->print_debugger());
        }
    }

    protected function _generate_full_name($user)
    {
        $name = $user->first_name . ' ' . $user->last_name;
        $name = trim($name);
        if (empty($name)) {
            $name = $user->username;
        }

        return $name;
    }

}
