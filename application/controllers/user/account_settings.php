<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Account_settings extends AuthController
{

    public $data = array(
        'sub_layout' => 'layouts/user_page',
    );

    public function __construct()
    {
        parent::__construct();
        $this->data['user'] = $this->ion_auth->user()->row();
		$this->load->model('account_settings_m');
    }

    public function index()
    {
        $this->load->model('users_m');
        $this->load->model('location_m');
        $this->data['metros'] = $this->location_m->get_all_metro_areas();

        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('first_name', 'First name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('last_name', 'Last name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('metro_id', 'Location', 'trim|required|integer');
        if($this->input->post('password')){
            $this->form_validation->set_rules('old_password', 'Old Password', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
            $this->form_validation->set_rules('password_confirm', 'Confirm password', 'required');
        }

        if ($this->form_validation->run() == TRUE) {
            $user_data = $this->input->post();
            unset($user_data['old_password'],$user_data['password'],$user_data['password_confirm']);
            $user_data['id'] = $this->data['user']->id;
            $this->users_m->save_user($user_data);
            $this->account_settings_m->save('metroId',$this->input->post('metro_id'));
            $identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));
            $change = $this->ion_auth->change_password($identity, $this->input->post('old_password'), $this->input->post('password'));
            if($change){
                redirect('logout');
            }
            redirect('user/settings');
        }

        $this->data['page_class'] = 'account-settings';
        $this->data['view'] = 'user/account_settings/index';
        $this->data['account_settings'] = $this->account_settings_m->get_account_settings();

        $this->_render_page();
    }

    public function avatar_upload()
    {
        $this->load->library('image_lib');
        $original_path = FCPATH . 'assets/uploads/users';
        $resized_path = FCPATH . 'assets/img/users';
        $old_avatar = $this->data['user']->avatar_path;
        //config for original upload
        $config = array(
            'allowed_types' => 'jpg|jpeg|gif|png',
            'max_size' => 20000, //2MB max
            'upload_path' => $original_path
        );

        //upload the image
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
        } else {
            $image_data = $this->upload->data();
        }

        //config for resize()
        $config = array(
            'source_image' => $image_data['full_path'],
            'new_image' => $resized_path,
            'maintain_ratio' => true,
            'width' => 152,
            'height' => 152
        );

        //resize the image
        $this->image_lib->initialize($config);
        $this->image_lib->resize();

        $data = array(
            'avatar_path' => $image_data['file_name'],
        );

        $this->db->where('id', $this->data['user']->id);
        if ($this->db->update('users', $data)) {
            unlink($original_path . '/' . $old_avatar);
            unlink($resized_path . '/' . $old_avatar);
        }
        unlink($image_data['full_path']);
        redirect(base_url('user/account_settings'));

    }
}