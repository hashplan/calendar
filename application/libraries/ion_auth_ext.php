<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . 'libraries/Ion_auth.php');

class Ion_auth_ext extends Ion_auth
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Register
     *
     * @param $username
     * @param $password_form
     * @param $email
     * @param array $additional_data
     * @param array $group_ids
     * @return array|bool|void
     */
    public function register($username, $password_form, $email, $additional_data = array(), $group_ids = array(), $auto_activate = false) //need to test email activation
    {
        if (!$password_form) {
            $password = $this->_generate_password();
        } else {
            $password = $password_form;
        }

        $this->ion_auth_model->trigger_events('pre_account_creation');

        $email_activation = $this->config->item('email_activation', 'ion_auth');

        if (!$email_activation) {
            $id = $this->ion_auth_model->register($username, $password, $email, $additional_data, $group_ids);
            if ($id !== FALSE) {
                $this->set_message('account_creation_successful');
                $this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_successful'));
                return $id;
            } else {
                $this->set_error('account_creation_unsuccessful');
                $this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_unsuccessful'));
                return FALSE;
            }
        } else {
            $id = $this->ion_auth_model->register($username, $password, $email, $additional_data, $group_ids);

            if (!$id) {
                $this->set_error('account_creation_unsuccessful');
                return FALSE;
            }

            $deactivate = $this->ion_auth_model->deactivate($id);

            if (!$deactivate) {
                $this->set_error('deactivate_unsuccessful');
                $this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_unsuccessful'));
                return FALSE;
            }

            $activation_code = $this->ion_auth_model->activation_code;
            $identity = $this->config->item('identity', 'ion_auth');
            $user = $this->ion_auth_model->user($id)->row();

            $data = array(
                'identity' => $user->{$identity},
                'id' => $user->id,
                'email' => $email
            );
            if(!$auto_activate){
                $data['activation'] = $activation_code;
            }
            if (!$password_form) {
                $data['password'] = $password;
            }
            if (!$this->config->item('use_ci_email', 'ion_auth')) {
                $this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_successful', 'activation_email_successful'));
                $this->set_message('activation_email_successful');
                return $data;
            } else {
                if(!$auto_activate){
                    $tmpl = $this->config->item('email_templates', 'ion_auth');
                    if ($password_form) {
                        $tmpl .= $this->config->item('email_activate', 'ion_auth');
                    }
                    else{
                        $tmpl .= 'activate_with_password.tpl.php';
                    }

                    $message = $this->load->view($tmpl, $data, true);

                    $this->email->clear();
                    $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
                    $this->email->to($email);
                    $this->email->subject($this->config->item('site_title', 'ion_auth') . ' - ' . $this->lang->line('email_activation_subject'));
                    $this->email->message($message);

                    if ($this->email->send() == TRUE) {
                        $this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_successful', 'activation_email_successful'));
                        $this->set_message('activation_email_successful');

                    }
                }
                else{
                    $this->activate($id);
                }
                return $id;
            }

            $this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_unsuccessful', 'activation_email_unsuccessful'));
            $this->set_error('activation_email_unsuccessful');
            return FALSE;
        }
    }

    /**
     * Generate password
     *
     * @param int $length
     * @return string
     */
    private function _generate_password($length = 8)
    {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }
}