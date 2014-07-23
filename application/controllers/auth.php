<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
        $this->load->helper('language');
    }

    //redirect if needed, otherwise display the user list
    function index()
    {
        $this->login();
    }

    function login()
    {
        $this->_login_redirect();
        $this->data['title'] = "Login";
        $this->data['view'] = 'auth/login';
        if ($this->input->is_ajax_request()) {
            $this->layout = '_layout_modal';
            $this->data['view'] = 'auth/modal_login';
            $this->data['modal_header'] = 'Login';
        }

        //validate form input
        $this->form_validation->set_rules('identity', 'Identity', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|callback_check_password');

        if ($this->form_validation->run() == true) {
            $remember = (bool)$this->input->post('remember');
            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
            {
                $this->session->set_flashdata('flash_message', $this->ion_auth->messages());
                $this->session->set_flashdata( 'flash_message_type', 'success');
                $this->_login_redirect();
            }
            else{
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                $this->data['errors'] = $this->ion_auth->errors();
            }

        }
        else{
            $this->data['errors'] = validation_errors();
        }
        $this->_render_page($this->layout, $this->data);
    }

    //log the user out
    function logout()
    {
        $this->data['title'] = "Logout";

        //log the user out
        $logout = $this->ion_auth->logout();

        //redirect them to the login page
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect('', 'refresh');
    }

    //change password
    function change_password()
    {
        $this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
        $this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        $user = $this->ion_auth->user()->row();

        if ($this->form_validation->run() == false) {
            //display the form
            //set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
            $this->data['old_password'] = array(
                'name' => 'old',
                'id' => 'old',
                'type' => 'password',
            );
            $this->data['new_password'] = array(
                'name' => 'new',
                'id' => 'new',
                'type' => 'password',
                'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
            );
            $this->data['new_password_confirm'] = array(
                'name' => 'new_confirm',
                'id' => 'new_confirm',
                'type' => 'password',
                'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
            );
            $this->data['user_id'] = array(
                'name' => 'user_id',
                'id' => 'user_id',
                'type' => 'hidden',
                'value' => $user->id,
            );

            //render
            $this->_render_page('auth/change_password', $this->data);
        } else {
            $identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));

            $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

            if ($change) {
                //if the password was successfully changed
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                $this->logout();
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('auth/change_password', 'refresh');
            }
        }
    }

    //forgot password
    function forgot_password()
    {
        $this->data['identity_field'] = $this->config->item('identity', 'ion_auth');
        $this->form_validation->set_rules($this->data['identity_field'], $this->lang->line('forgot_password_validation_email_label'), 'required');

        if ($this->form_validation->run() == false) {
            //set any errors and display the form
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['view'] = 'auth/forgot_password';
            $this->_render_page($this->layout, $this->data);
        }
        else {
            $identity = $this->ion_auth->where($this->data['identity_field'], strtolower($this->input->post($this->data['identity_field'])))->users()->row();
            if (empty($identity)) {
                $this->ion_auth->set_message('forgot_password_email_not_found');
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                $this->data['view'] = 'auth/forgot_password';
                $this->_render_page($this->layout, $this->data);
            }
            else{
                //run the forgotten password method to email an activation code to the user
                $forgotten = $this->ion_auth->forgotten_password($identity->{$this->data['identity_field']});
                if ($forgotten) {
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    redirect('login', 'refresh');
                }
                else {
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                    $this->data['view'] = 'auth/forgot_password';
                    $this->_render_page($this->layout, $this->data);
                }
            }
        }
    }

    //reset password - final step for forgotten password
    public function reset_password($code = NULL)
    {
        if (!$code) {
            show_404();
        }

        $user = $this->ion_auth->forgotten_password_check($code);
        $this->data['view'] = 'auth/reset_password';

        if ($user) {
            //if the code is valid then display the password reset form

            $this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
            $this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

            if ($this->form_validation->run() == false) {
                $this->data['csrf'] = $this->_get_csrf_nonce();
                $this->data['code'] = $code;
                $this->data['user_id'] = $user->id;

                //render
                $this->_render_page($this->layout, $this->data);
            }
            else {
                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id')) {
                    $this->ion_auth->clear_forgotten_password_code($code);
                    show_error($this->lang->line('error_csrf'));
                }
                else
                {
                    // finally change the password
                    $identity = $user->{$this->config->item('identity', 'ion_auth')};

                    $change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

                    if ($change) {
                        //if the password was successfully changed
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        $this->logout();
                    }
                    else {
                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                        redirect('reset_password' . $code, 'refresh');
                    }
                }
            }
        }
        else {
            //if the code is invalid then send them back to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("forgot_password", 'refresh');
        }
    }


    //activate the user
    function activate($id, $code = false)
    {
        if ($code !== false) {
            $activation = $this->ion_auth->activate($id, $code);
        } else if ($this->ion_auth->is_admin()) {
            $activation = $this->ion_auth->activate($id);
        }

        if ($activation) {
            //redirect them to the auth page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("login", 'refresh');
        } else {
            //redirect them to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("forgot_password", 'refresh');
        }
    }

    //deactivate the user
    function deactivate($id = NULL)
    {
        $id = $this->config->item('use_mongodb', 'ion_auth') ? (string)$id : (int)$id;

        $this->load->library('form_validation');
        $this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
        $this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

        if ($this->form_validation->run() == FALSE) {
            // insert csrf check
            $this->data['csrf'] = $this->_get_csrf_nonce();
            $this->data['user'] = $this->ion_auth->user($id)->row();

            $this->_render_page('auth/deactivate_user', $this->data);
        } else {
            // do we really want to deactivate?
            if ($this->input->post('confirm') == 'yes') {
                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
                    show_error($this->lang->line('error_csrf'));
                }

                // do we have the right userlevel?
                if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
                    $this->ion_auth->deactivate($id);
                }
            }

            //redirect them back to the auth page
            redirect('auth', 'refresh');
        }
    }

    //create a new user
    function create_user()
    {
        $this->_login_redirect();

        $this->data['title'] = "SignUp";
        $this->data['view'] = 'auth/create_user';
        if ($this->input->is_ajax_request()) {
            $this->layout = '_layout_modal';
            $this->data['view'] = 'auth/modal_create_user';
            $this->data['modal_header'] = 'Join Hashplan today, it\'s FREE!';
        }

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
                $this->session->set_flashdata('flash_message', $this->ion_auth->messages());
                redirect("auth", 'refresh');
            }
            else{
                $this->data['errors'] = $this->ion_auth->errors();
            }

        }
        else {
            $this->data['errors'] = validation_errors();
        }
        $this->_render_page($this->layout, $this->data);
    }

    //edit a user
    function edit_user($id)
    {
        $this->data['title'] = "Edit User";

        if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id))) {
            redirect('auth', 'refresh');
        }

        $user = $this->ion_auth->user($id)->row();
        $groups = $this->ion_auth->groups()->result_array();
        $currentGroups = $this->ion_auth->get_users_groups($id)->result();

        //validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required|xss_clean');
        //$this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'required|xss_clean');
        //$this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'required|xss_clean');
        $this->form_validation->set_rules('groups', $this->lang->line('edit_user_validation_groups_label'), 'xss_clean');

        if (isset($_POST) && !empty($_POST)) {
            // do we have a valid request?
            if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
                show_error($this->lang->line('error_csrf'));
            }

            $data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                /**'company'    => $this->input->post('company'),
                 * 'phone'      => $this->input->post('phone'),
                 **/
            );

            //Update the groups user belongs to
            $groupData = $this->input->post('groups');

            if (isset($groupData) && !empty($groupData)) {

                $this->ion_auth->remove_from_group('', $id);

                foreach ($groupData as $grp) {
                    $this->ion_auth->add_to_group($grp, $id);
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

                //check to see if we are creating the user
                //redirect them back to the admin page
                $this->session->set_flashdata('message', "User Saved");
                if ($this->ion_auth->is_admin()) {
                    redirect('auth', 'refresh');
                } else {
                    redirect('/', 'refresh');
                }
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

        $this->data['first_name'] = array(
            'name' => 'first_name',
            'id' => 'first_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('first_name', $user->first_name),
        );
        $this->data['last_name'] = array(
            'name' => 'last_name',
            'id' => 'last_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('last_name', $user->last_name),
        );
        /**$this->data['company'] = array(
         * 'name'  => 'company',
         * 'id'    => 'company',
         * 'type'  => 'text',
         * 'value' => $this->form_validation->set_value('company', $user->company),
         * );
         * $this->data['phone'] = array(
         * 'name'  => 'phone',
         * 'id'    => 'phone',
         * 'type'  => 'text',
         * 'value' => $this->form_validation->set_value('phone', $user->phone),
         * );**/
        $this->data['password'] = array(
            'name' => 'password',
            'id' => 'password',
            'type' => 'password'
        );
        $this->data['password_confirm'] = array(
            'name' => 'password_confirm',
            'id' => 'password_confirm',
            'type' => 'password'
        );

        $this->_render_page('auth/edit_user', $this->data);
    }

    // create a new group
    function create_group()
    {
        $this->data['title'] = $this->lang->line('create_group_title');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        }

        //validate form input
        $this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'required|alpha_dash|xss_clean');
        $this->form_validation->set_rules('description', $this->lang->line('create_group_validation_desc_label'), 'xss_clean');

        if ($this->form_validation->run() == TRUE) {
            $new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
            if ($new_group_id) {
                // check to see if we are creating the group
                // redirect them back to the admin page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("auth", 'refresh');
            }
        } else {
            //display the create group form
            //set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['group_name'] = array(
                'name' => 'group_name',
                'id' => 'group_name',
                'type' => 'text',
                'value' => $this->form_validation->set_value('group_name'),
            );
            $this->data['description'] = array(
                'name' => 'description',
                'id' => 'description',
                'type' => 'text',
                'value' => $this->form_validation->set_value('description'),
            );

            $this->_render_page('auth/create_group', $this->data);
        }
    }

    //edit a group
    function edit_group($id)
    {
        // bail if no group id given
        if (!$id || empty($id)) {
            redirect('auth', 'refresh');
        }

        $this->data['title'] = $this->lang->line('edit_group_title');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        }

        $group = $this->ion_auth->group($id)->row();

        //validate form input
        $this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash|xss_clean');
        $this->form_validation->set_rules('group_description', $this->lang->line('edit_group_validation_desc_label'), 'xss_clean');

        if (isset($_POST) && !empty($_POST)) {
            if ($this->form_validation->run() === TRUE) {
                $group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

                if ($group_update) {
                    $this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
                } else {
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                }
                redirect("auth", 'refresh');
            }
        }

        //set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        //pass the user to the view
        $this->data['group'] = $group;

        $this->data['group_name'] = array(
            'name' => 'group_name',
            'id' => 'group_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('group_name', $group->name),
        );
        $this->data['group_description'] = array(
            'name' => 'group_description',
            'id' => 'group_description',
            'type' => 'text',
            'value' => $this->form_validation->set_value('group_description', $group->description),
        );

        $this->_render_page('auth/edit_group', $this->data);
    }


    private function _get_csrf_nonce()
    {
        $this->load->helper('string');
        $key = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return array($key => $value);
    }

    private function _valid_csrf_nonce()
    {
        if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
            $this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue')
        ) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    public function facebook_login()
    {
        //var_dump($this->session->all_userdata()); $this->session->sess_destroy(); die();
        $this->load->library('facebook');
        $this->load->library('ion_auth_ext');
        //$this->load->model('account_settings_m');
        $fb_user = $this->facebook->get_user();
        if(!$fb_user){
            $login_url = $this->facebook->get_login_url();
            redirect($login_url);
        }
        else{
            //check for facebook id in the account settings table
            $this->load->model('account_settings_m');
            $settings = $this->account_settings_m->find_user_by_facebook_id($fb_user['id']);
            if($settings){
                $user = $this->ion_auth_ext->user($settings->userId)->row();

                if($user){
                    $this->_custom_login($user);
                    $this->_login_redirect();
                }
            }
            else{
                //if no, then check user with such facebook email
                $user = $this->ion_auth_ext->where('email',$fb_user['email'])->user()->row();

                if($user){
                    //add facebook data to user settings and log in this user
                    $this->account_settings_m->save('fb_id', $fb_user['id'], $user->id);
                    $this->account_settings_m->save('fb_email', $fb_user['email'], $user->id);
                    $this->_custom_login($user);
                }
                else{
                    //if no, then register user with facebook email login,
                    //generate a random password and send it along with an activation email
                    $username = strtolower($fb_user['name']);
                    $email = strtolower($fb_user['email']);
                    $password = null;
                    $additional_data = array(
                        'first_name' => $fb_user['first_name'],
                        'last_name' => $fb_user['last_name']
                    );
                    $user_id = $this->ion_auth_ext->register($username, $password, $email, $additional_data, array(), true);
                    if ($user_id) {
                        $user = $this->ion_auth_ext->user($user_id)->row();
                        $this->account_settings_m->save('fb_id', $fb_user['id'], $user->id);
                        $this->account_settings_m->save('fb_email', $fb_user['email'], $user->id);
                        $this->_custom_login($user);
                        $this->_login_redirect($user);
                    }
                }

            }
        }
    }

    public function facebook_signout(){
        $this->load->library('facebook');
        $logout_url = $this->facebook->get_logout_url();
        redirect($logout_url);
    }

    public function facebook_connect(){
        //TODO
    }

    private function _custom_login($user){
        $this->ion_auth->set_session($user);
        $this->ion_auth->update_last_login($user->id);
        $this->ion_auth->clear_login_attempts($user->email);
    }

    private function _login_redirect()
    {
        if ($this->ion_auth->logged_in()) {
            if ($this->ion_auth->in_group("admin")) {
                if($this->input->is_ajax_request()){
                    ob_clean();
                    header('Content-type: text/json');
                    echo json_encode(array('redirect' => 'admin'));
                    die();
                }
                else{
                    redirect('admin');
                }
            }
            elseif ($this->ion_auth->in_group("members")) {
                if($this->input->is_ajax_request()){
                    ob_clean();
                    header('Content-type: text/json');
                    echo json_encode(array('redirect' => 'user'));
                    die();
                }
                else{
                    redirect('user');
                }

            }
            else {
                redirect('/');
            }
        }
    }

    public function check_password(){
        $remember = (bool)$this->input->post('remember');
        if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
               return TRUE;
        }
        $this->form_validation->set_message('check_password', $this->ion_auth->errors());
        return FALSE;
    }
}

