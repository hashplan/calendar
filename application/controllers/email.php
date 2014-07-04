<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//email with gmail, we have the hashplans@gmail.com account, also have @hashplans accounts via godaddy

class Email extends MY_Controller {

	public $data = array(
		'page_class' => 'generic'
	);
	public $layout = 'layouts/default';

	function __construct(){
		parent::__construct();
	}

	public function index(){ //this one can be deleted once contact form is hooked up
	$this->data['subview']='email/contact';
	$this->load->view('_layout_modal',$this->data);
	}
		
	protected function send($from_user_email, $type, $to_user_email, $subject, $sender = null){

		$this->config->load('email', TRUE);
		$this->load->library('email');
		$this->email->set_newline("\r\n");
		$this->email->clear(true);

		if (is_null($sender)) //then system generated email
		{
			$from_user_email = 'hashplans@gmail.com';
			$from_user_name = 'Hashplan';
		}

		$this->email->from($from_email, $from_name);
		$this->email->to($to_user_email);

		$this->email->subject($subject);

		$html = $this->render($from_user_email, $from_user_name, $to_user_email, $to_user_name = null, $subject, true);
		
		$this->email->message($html);

		//if have some attachment to send
		//$file = base_url() . 'attachments/filename.txt';
		//$this->email->attach($file);
		$result = $this->email->send();

		if (!$result)
		{
			show_error($this->email->print_debugger());
		}
		else
		{
			echo 'Your email was sent.';
			//$this->load->view('confirmation');
		}
		return $result;
}
		
	public function welcome_email($email = '', $user_name = '')
		{
			$this->data['email'] = $email;
			$this->data['user_name'] = $user_name;
			$this->view = 'email/welcome_email';
			return $this->send(null, 'auto', $email); //auto type could be system-generated email vs other type could be user-generated
		}

	public function contact(){
	//field name, error message, validation rules
	$this->form_validation->set_rules('user_name','Name','trim|required');
	$this->form_validation->set_rules('user_email','Email','trim|required|valid_email');
	$this->form_validation->set_rules('contact_description','Description','trim|required');
	if($this->form_validation->run() == FALSE)
	{
		$this->data['subview']='email/contact';
		$this->load->view('_layout_modal',$this->data);
	} 
	else {
		//validation passed and send te email
		$user_name = $this->input->post('user_name');
		$from_user_email =$this->input->post('user_email'); 
		$contact_description =$this->input->post('contact_description'); 
		return $this->send($from_user_email, 'user', 'info@hashplans.com','Contact Form'); //auto type could be system-generated email vs other type could be user-generated
	}	
}		
	
	//to render the html page which will be sent in email
    public function render($from_user_email = null, $from_user_name = null, $to_user_email = null, $to_user_name = null, $subject = null, $return = false, $layout = null, $view = null)
    {

        if ($layout == null)
        {
            $layout = 'layouts/default';
        }

        if ($view == null)
        {
            $view = '';
        }

        $email_content = $this->load->view($layout, array(
             'view' => $view,
             'data' => $this->data), $return);

        return $email_content;
    }

}

?>