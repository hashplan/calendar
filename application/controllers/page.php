<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Page extends MY_Controller {

	public $data = array(
		'sub_layout' => 'layouts/generic_page',
	);

	public function index(){
		$this->data['page_class'] = 'homepage';
		$this->data['view'] = 'page/homepage';
		$this->_render_page();
	}

	public function about(){
		$this->data['page_class'] = 'about';
		$this->data['view'] = 'page/about';
		$this->_render_page();
	}

	public function faq(){
		$this->data['page_class'] = 'faq';
		$this->data['view'] = 'page/faq';
		$this->_render_page();
	}

	public function howitworks(){
		$this->data['page_class'] = 'howitworks';
		$this->data['view'] = 'page/howitworks';
		$this->_render_page();
	}
}