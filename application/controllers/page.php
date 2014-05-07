<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Page extends MY_Controller {
	function __construct(){
		parent::__construct();
		}
		
public function index(){
	$this->data['subview']='homepage';
	$this->load->view('_layout_main',$this->data);
}

public function about(){
	$this->data['subview']='about';
	$this->load->view('_layout_main',$this->data);
}

public function faq(){
	$this->data['subview']='faq';
	$this->load->view('_layout_main',$this->data);
}

public function howitworks(){
	$this->data['subview']='howitworks';
	$this->load->view('_layout_main',$this->data);
}

}
?>