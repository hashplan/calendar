<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//email with gmail, we have the hashplans@gmail.com account

class Email extends MY_Controller {

	function __construct(){
		parent::__construct();
	}

	public function index(){
	$this->data['subview']='email/contact';
	$this->load->view('_layout_modal',$this->data);
	}
	
	function contact(){
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
		$user_email =$this->input->post('user_email'); 
		$contact_description =$this->input->post('contact_description'); 
		
		$this->load->library('email');
		$this->email->set_newline("\r\n");
		
		$this->email->from('hashplans@gmail.com','Hashplan');
		$this->email->to($user_email);
		$this->email->subject('Testing contact form');
		$this->email->message('Contact is working. Great!');
		
		//if have some attachment to send
		//$file = base_url() . 'attachments/filename.txt';
		//$this->email->attach($file);
		
		if($this->email->send()){
			echo 'Your email was sent.';
			//$this->load->view('confirmation');
		}
		else {
		show_error($this->email->print_debugger());
		}
	}	
	}
}
?>