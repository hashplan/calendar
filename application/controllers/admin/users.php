<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends AdminController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index($page = 1, $limit = 50, $sort = 'id', $type = 'ASC')
    {
        $this->load->model('ion_auth_ext_model');
        $page || $page = 1;
        $offset = $limit * $page - $limit;
        $this->data['users'] = $this->ion_auth_ext_model
            ->limit($limit)
            ->offset($offset)
            ->include_group_info()
            ->order_by($sort, $type)
            ->users()
            ->result();

        if ($this->input->is_ajax_request()) {
            header('Content-Type: application/json');
            echo json_encode($this->data['users']);
            die();
        }
        else {
            $js_assets = array(
                array('bootstrap-table.js'),
            );
            $css_assets = array(
                array('bootstrap-table.css'),
            );
            $this->carabiner->group('page_assets', array('js' => $js_assets, 'css' => $css_assets));
            $this->data['view'] = 'admin/users/index';
        }

        $this->_render_page();
    }

    public function edit($userId)
    {

    }

    public function add()
    {

    }


}