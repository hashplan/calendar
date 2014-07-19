<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Email extends CI_Email {

    /*protected $layout = '_layout_email';
    protected $data = array(
        'subject' => 'Hashplans Notification',
        'from' => array('noreply@hashplans.com', 'Hashplans')
    );*/

    public function __construct(){
        parent::__construct();
    }

    //send to invited
   /* public function send_friend_invite_email($from, $to){
        $this->data['view'] = 'email/friend_invite.tpl.php';
        $this->data['subject'] = 'Friendship request';
        $this->data['to'] = $to->email;
        $this->data['from_name'] = $this->generate_full_name($from);
        echo $this->print_debugger();
        $this->send();
        echo $this->print_debugger();
    }

    //send back to inviter
    public function send_friend_confirmed_email(){
        $this->data['view'] = 'email/friend_confirmed.tpl.php';
    }

    //send back to inviter
    public function send_friend_refused_email(){
        $this->data['view'] = 'email/friend_refused.tpl.php';

    }

    //send to invited
    public function send_event_invite_email(){
        $this->data['view'] = 'email/event_invite.tpl.php';
    }

    //send back to inviter
    public function send_event_confirmed_email(){
        $this->data['view'] = 'email/event_confirmed.tpl.php';
    }

    //send back to inviter
    public function send_event_refused_email(){
        $this->data['view'] = 'email/event_invite.tpl.php';
    }

    public function send_confirm_form_email(){
        $this->data['view'] = 'email/event_invite.tpl.php';
    }

    protected function render(){
        $this->subject($this->data['subject']);
        $this->to($this->data['to']);
        $this->message($this->load->view($this->layout, $this->data, TRUE));
    }

    public function generate_full_name($user)
    {
        $name = $user->first_name . ' ' . $user->last_name;
        $name = trim($name);
        if (empty($name)) {
            $name = $user->username;
        }

        return $name;
    }*/

}
