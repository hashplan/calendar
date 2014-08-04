<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends AdminController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index($page = 1, $limit = 50)
    {
        $this->load->model('ion_auth_ext_model');
        $page || $page = 1;
        $offset = $limit * $page - $limit;
        $this->data['users'] = $this->ion_auth_ext_model
            ->limit($limit)
            ->offset($offset)
            ->include_group_info()
            ->order_by('id', 'ASC')
            ->users()
            ->result();
        $this->data['view'] = 'admin/users/index';
        $this->_render_page();
    }

    public function edit($userId)
    {

    }

    public function add()
    {

    }


}