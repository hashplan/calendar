<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends AdminController
{

    public function __construct()
    {
        parent::__construct();
        Menu::setActive('admin/users');
    }

    public function index($page = 1, $limit = 50, $sort = 'id', $type = 'ASC')
    {
        $this->load->model('ion_auth_ext_model');
        $page || $page = 1;
        $offset = $limit * $page - $limit;
        $counters = $this->get_counters();

        $paged = new stdClass();
        $paged->current_page = $page;
        $paged->total_pages = ceil($counters['users'] / $limit);
        $paged->items_on_page = $limit;
        $paged->has_previous = $page > 1;
        $paged->previous_page = $paged->has_previous ? $page - 1 : $page;
        $paged->total_rows = $counters['users'];
        $paged->has_next = $paged->total_pages > $page;
        $paged->next_page = $paged->has_next ? $page + 1 : $page;
        $this->data['pagination'] = $this->get_paging($paged, 'admin/users/');

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
        } else {
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
        $this->data['title'] = "Edit User";
        $this->data['view'] = 'admin/users/edit';

        $user = $this->ion_auth->user($userId)->row();
        $groups = $this->ion_auth->groups()->result_array();
        $currentGroups = $this->ion_auth->get_users_groups($userId)->result();

        //validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('groups', $this->lang->line('edit_user_validation_groups_label'), 'xss_clean');

        if (isset($_POST) && !empty($_POST)) {
            // do we have a valid request?
            if ($this->_valid_csrf_nonce() === FALSE || $userId != $this->input->post('id')) {
                show_error($this->lang->line('error_csrf'));
            }

            $data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name')
            );

            //Update the groups user belongs to
            $groupData = $this->input->post('groups');

            if (isset($groupData) && !empty($groupData)) {
                $this->ion_auth->remove_from_group('', $user->id);
                foreach ($groupData as $grp) {
                    $this->ion_auth->add_to_group($grp, $user->id);
                }
            }

            //update the password if it was posted
            if ($this->input->post('password')) {
                $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
                $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');

                $data['password'] = $this->input->post('password');
            }

            if ($this->form_validation->run() === TRUE) {
                $this->ion_auth->update($user->id, $data);
                $this->session->set_flashdata('message', "User Saved");
                redirect('admin/users', 'refresh');
            }
        }

        //display the edit user form
        $this->data['csrf'] = $this->_get_csrf_nonce();

        //set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        //pass the user to the view
        $this->data['user'] = $user;
        $this->data['groups'] = $groups;
        $this->data['currentGroups'] = $currentGroups;

        $this->_render_page();
    }

    public function add()
    {
        $this->data['title'] = "Create New User";
        $this->data['view'] = 'admin/users/add';

        //validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[users.email]'); //   is_unique['.$this->config->item('tables','ion_auth')['users'].'.email]');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[8]'); //[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required|matches[password]');

        if ($this->form_validation->run() == true) {
            $username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
            $email = strtolower($this->input->post('email'));
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name')
            );
            if ($this->ion_auth->register($username, $password, $email, $additional_data)) {
                redirect("admin/users");
            }
            else{
                $this->data['errors'] = $this->ion_auth->errors();
            }

        }
        else {
            $this->data['errors'] = validation_errors();
        }
        $this->_render_page();
    }

    public function deactivate($userId)
    {
        $this->data['view'] = 'admin/users/deactivate';
        $id = $this->config->item('use_mongodb', 'ion_auth') ? (string)$userId : (int)$userId;

        $this->load->library('form_validation');
        $this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
        $this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->data['csrf'] = $this->_get_csrf_nonce();
            $this->data['user'] = $this->ion_auth->user($userId)->row();

            $this->_render_page();
        }
        else {
            if ($this->input->post('confirm') == 'yes') {
                if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
                    show_error($this->lang->line('error_csrf'));
                }
                $this->ion_auth->deactivate($id);
            }
            redirect('admin/users', 'refresh');
        }
    }

    public function activate($id){
        $this->ion_auth->activate($id);
        redirect('admin/users', 'refresh');
    }
}