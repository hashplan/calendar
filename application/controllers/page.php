<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Page extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data['sub_layout'] = 'layouts/generic_page';
        $js_assets = array(
            array('page.js'),
        );
        $css_assets = array(
            array('page.css'),
        );
        $this->carabiner->group('page_assets', array('js' => $js_assets, 'css' => $css_assets) );
    }

    public function index()
    {
        $this->data['page_class'] = 'homepage';
        $this->data['view'] = 'page/homepage2';

        $this->_render_page();
    }

    public function about()
    {
        $this->data['page_class'] = 'about';
        $this->data['view'] = 'page/about';
        $this->_render_page();
    }

    public function faq()
    {
        $this->data['page_class'] = 'faq';
        $this->data['view'] = 'page/faq';
        $this->_render_page();
    }

    public function howitworks()
    {
        $this->data['page_class'] = 'howitworks';
        $this->data['view'] = 'page/howitworks';
        $this->_render_page();
    }

    public function contact_us()
    {

        $this->data['page_class'] = 'contact_us';
        $this->data['view'] = 'page/contact';
        $this->data['sub_layout']='page/contact';
        if($this->input->is_ajax_request()){
            $this->data['modal_header'] = 'Contact us';
            $this->layout = '_layout_modal';
        }

        $this->form_validation
            ->set_rules('user_name','Name','trim|required')
            ->set_rules('user_email','Email','trim|required|valid_email')
            ->set_rules('contact_description','Description','trim|required');

        if($this->form_validation->run() == TRUE)
        {
            $this->load->library('hashplans_mailer');
            $this->hashplans_mailer->send_contact_us_form_email(array(
                'user_name' => $this->input->post('user_name'),
                'user_email' => $this->input->post('user_email'),
                'contact_description' => $this->input->post('contact_description'),
            ));
            header('Content-Type: application/json');
            echo json_encode(array('result' => 'success'));
            die();
        }
        elseif(validation_errors()){
            header('Content-Type: application/json');
            echo json_encode(array('result' => 'errors', 'errors' => validation_errors()));
            die();
        }
        $this->_render_page();
    }
}