<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property CI_DB_active_record $db              This is the platform-independent base Active Record implementation class.
 * @property CI_DB_forge $dbforge                 Database Utility Class
 * @property CI_Benchmark $benchmark              This class enables you to mark points and calculate the time difference between them.<br />  Memory consumption can also be displayed.
 * @property CI_Calendar $calendar                This class enables the creation of calendars
 * @property CI_Cart $cart                        Shopping Cart Class
 * @property CI_Config $config                    This class contains functions that enable config files to be managed
 * @property CI_Controller $controller            This class object is the super class that every library in.<br />CodeIgniter will be assigned to.
 * @property CI_Email $email                      Permits email to be sent using Mail, Sendmail, or SMTP.
 * @property CI_Encrypt $encrypt                  Provides two-way keyed encoding using XOR Hashing and Mcrypt
 * @property CI_Exceptions $exceptions            Exceptions Class
 * @property CI_Form_validation $form_validation  Form Validation Class
 * @property CI_Ftp $ftp                          FTP Class
 * @property CI_Hooks $hooks                      Provides a mechanism to extend the base system without hacking.
 * @property CI_Image_lib $image_lib              Image Manipulation class
 * @property CI_Input $input                      Pre-processes global input data for security
 * @property CI_Lang $lang                        Language Class
 * @property CI_Loader $load                      Loads views and files
 * @property CI_Log $log                          Logging Class
 * @property CI_Model $model                      CodeIgniter Model Class
 * @property CI_Output $output                    Responsible for sending final output to browser
 * @property CI_Pagination $pagination            Pagination Class
 * @property CI_Parser $parser                    Parses pseudo-variables contained in the specified template view,<br />replacing them with the data in the second param
 * @property CI_Profiler $profiler                This class enables you to display benchmark, query, and other data<br />in order to help with debugging and optimization.
 * @property CI_Router $router                    Parses URIs and determines routing
 * @property CI_Session $session                  Session Class
 * @property CI_Sha1 $sha1                        Provides 160 bit hashing using The Secure Hash Algorithm
 * @property CI_Table $table                      HTML table generation<br />Lets you create tables manually or from database result objects, or arrays.
 * @property CI_Trackback $trackback              Trackback Sending/Receiving Class
 * @property CI_Typography $typography            Typography Class
 * @property CI_Unit_test $unit_test              Simple testing class
 * @property CI_Upload $upload                    File Uploading Class
 * @property CI_URI $uri                          Parses URIs and determines routing
 * @property CI_User_agent $user_agent            Identifies the platform, browser, robot, or mobile devise of the browsing agent
 * @property CI_Validation $validation            //dead
 * @property CI_Xmlrpc $xmlrpc                    XML-RPC request handler class
 * @property CI_Xmlrpcs $xmlrpcs                  XML-RPC server class
 * @property CI_Zip $zip                          Zip Compression Class
 * @property CI_Javascript $javascript            Javascript Class
 * @property CI_Jquery $jquery                    Jquery Class
 * @property CI_Utf8 $utf8                        Provides support for UTF-8 environments
 * @property CI_Security $security                Security Class, xss, csrf, etc...
 */
class MY_Controller extends CI_Controller
{
    public $data = array(
        'sub_layout' => 'layouts/generic_page',
        'page_class' => 'generic',
        'errors' => array()
    );
    public $layout = '_layout_default';

    function __construct()
    {
        parent::__construct();

        if (empty($this->data['data'])) {
            $this->data['data'] = array();
        }

        /*if(ENVIRONMENT == 'development'){
            if($this->input->is_ajax_request()){
                $this->output->enable_profiler(FALSE);
            }
            else{
                $this->output->enable_profiler(TRUE);
            }
        }*/

        $this->load->library('carabiner');
        $this->_load_assets();
    }

    protected function _load_assets()
    {
        $css = array(
            array('bootstrap.min.css'),
            array('datepicker.css'),
            array('bootstrap-formhelpers.min.css'),
            array('styles.css')
        );
        $js = array(
            array('bootstrap.min.js'),
            array('bootstrap-datepicker.js'),
            array('bootstrap-formhelpers.min.js'),
            array('global.js')
        );
        $this->carabiner->group('bootstrap', array('css' => $css, 'js' => $js));

        $js = array(
            array('jquery-1.11.0.js'),
            array('jquery-ui-1.10.4.custom.min.js'),
            array('jquery.tmpl.js')
        );
        $this->carabiner->group('header_js', array('js' => $js));


    }

    protected function _render_page()
    {
        if ($this->input->is_ajax_request()&&$this->input->post()) {
            ob_clean();
            header('Content-type: text/json');
            echo json_encode($this->data);
            die();
        }
        else
        {
            $this->load->view($this->layout, $this->data);
        }
    }
}


//Protocontroller for authorized users
class AuthController extends MY_Controller
{
    public $user = NULL;
    public $friends = NULL;

    public function __construct()
    {
        parent::__construct();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');

        if (!$this->ion_auth->in_group("members") && !$this->ion_auth->in_group("admin")) {
            redirect('auth/login', 'refresh');
        }

        $this->user = $this->ion_auth->user()->row();
        $this->friends = $this->update_friend_list();

        $css = array(
            array('styles.css')
        );
        $this->carabiner->group('page_css', array('css' => $css));
    }

    public function get_user_identifier()
    {
        if ($this->ion_auth->in_group("members")) {
            $identifier = 'user';
        } elseif ($this->ion_auth->in_group("admin")) {
            $identifier = 'admin';
        }
        return $identifier;
    }

    protected function update_friend_list($force = false)
    {
        $friend_list_last_update = $this->session->userdata('friend_list_last_update');
        $friend_list_cache_expiry_time = $this->config->item('friend_list_cache_expiry_time');

        if (!$friend_list_last_update || time() - $friend_list_cache_expiry_time > $friend_list_last_update || $force) {
            $this->load->model('users_m');
            $friends = $this->users_m->get_friends(array(), true);
            $friend_ids = array();
            if (!empty($friends)) {
                foreach ($friends as $friend) {
                    $friend_ids[] = $friend->id;
                }
            }
            $this->session->set_userdata(array('friend_ids' => $friend_ids, 'friend_list_last_update' => time()));
        }
        return $this->session->userdata('friend_ids');
    }
}

//Protocontroller for admin
class AdminController extends AuthController
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->in_group("admin")) {
            show_404();
        }
    }
}

class EmailController extends MY_Controller
{
    public $layout = '_layout_email';
    public function __construct()
    {
        parent::__construct();
    }

    //to render the html page which will be sent in email
    public function render($view = null, $layout = null, $return = false)
    {

        if (!is_null($layout)) {
            $this->layout = $layout;
        }

        if ($view == null) {
            $view = '';
        }

        $email_content = $this->load->view($this->layout, array(
            'view' => $view,
            'data' => $this->data), $return);

        return $email_content;
    }
}