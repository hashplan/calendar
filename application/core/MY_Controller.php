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
            array('global.js'),
            array('back_to_top.js')
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
        if ($this->input->is_ajax_request() && $this->input->post()) {
            ob_clean();
            header('Content-type: text/json');
            echo json_encode($this->data);
            die();
        }
        else {
            $this->load->view($this->layout, $this->data);
        }
    }

    protected function get_paging($paged, $base_url = '')
    {
        $result = '';
        if (isset($paged) && !empty($paged) && isset($base_url)) {
            $result .= '<div class="text-center">';
            if ($paged->total_rows != 0 && $paged->items_on_page != 0 && $paged->total_pages > 1) {
                $result .= '<ul class="pagination">';
                if ($paged->has_previous) {
                    $result .= '<li><a href="' . base_url($base_url . $paged->previous_page) . '">&laquo;</a></li>';
                }
                if ($paged->current_page - 7 >= 1) {
                    $result .= '<li><a href="' . base_url($base_url . '1') . '">1</a></li>';
                    $result .= '<li><a href="' . base_url($base_url . ($paged->current_page - 6)) . '">...</a></li>';
                }
                $start_page = $paged->current_page - 6 <= 1 ? 1 : $paged->current_page - 5;
                $end_page = $paged->current_page + 6 >= $paged->total_pages ? $paged->total_pages : $paged->current_page + 6;
                for ($i = $start_page; $i <= $end_page; $i++) {
                    $active = $paged->current_page == $i ? ' class="active"' : '';
                    $result .= '<li' . $active . '><a href="' . base_url($base_url . $i) . '">' . $i . '</a></li>';
                }
                if ($paged->current_page + 7 <= $paged->total_pages) {
                    $result .= '<li><a href="' . base_url($base_url . ($paged->current_page + 6)) . '">...</a></li>';
                    $result .= '<li><a href="' . base_url($base_url . $paged->total_pages) . '">' . $paged->total_pages . '</a></li>';
                }
                if ($paged->has_next) {
                    $result .= '<li><a href="' . base_url($base_url . $paged->next_page) . '">&raquo;</a></li>';
                }
                $result .= '</ul>';
            }
            $result .= '</div>';
        }

        return $result;
    }

    protected function _get_csrf_nonce()
    {
        $this->load->helper('string');
        $key = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return array($key => $value);
    }

    protected function _valid_csrf_nonce()
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
}


//Protocontroller for authorized users
class AuthController extends MY_Controller
{
    private $user = NULL;
    private $friends = NULL;
    private $pymk = NULL;
    private $my_name = NULL;
    private  $my_settings = NULL;
    private  $my_metroarea = NULL;
    private  $banner = array();

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('cookie');

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');

        if (!$this->ion_auth->in_group("members") && !$this->ion_auth->in_group("admin")) {
            $this->session->set_userdata('redirect_to', $this->router->uri->uri_string());
            redirect('auth/login', 'refresh');
        }
        $redirect_to = $this->session->userdata('redirect_to');
        if ($redirect_to) {
            $this->session->unset_userdata('redirect_to');
            redirect($redirect_to, 'refresh');
        }

        $this->user = $this->ion_auth->where('Active', 1)->user()->row();
        if (empty($this->user)) {
            $this->session->set_flashdata('flash_message', 'Your account has been deactivated');
            redirect('logout', 'refresh');
        }

        $this->update_user_name();
        $this->update_user_settings();
        $this->update_user_location();

        $this->fill_banners();

        $this->update_friend_list();
        $this->update_people_you_may_know_list();
        $this->data['user'] = $this->get_user();
        $this->user_name = $this->get_user()->first_name;

        $css = array(
            array('styles.css')
        );
        $this->carabiner->group('page_css', array('css' => $css));
    }

    /**
     * Cached and fill full friend list
     *
     * @param bool $isForce
     */
    protected function update_friend_list($isForce = false)
    {
        $friend_list_last_update = $this->session->userdata('friend_list_last_update');
        $friend_list_cache_expiry_time = $this->config->item('friend_list_cache_expiry_time');

        if (!$friend_list_last_update || time() - $friend_list_cache_expiry_time > $friend_list_last_update || $isForce) {
            $this->load->model('users_m');
            $friends = $this->users_m->get_friends(array(), true);
            $friend_ids = array();
            if (!empty($friends)) {
                foreach ($friends as $friend) {
                    $friend_ids[] = $friend->id;
                }
            }
            $this->session->set_userdata(array('friend_ids' => $friend_ids, 'friend_list_last_update' => time()));
            $this->friends = $friend_ids;
        }
        else {
            $this->friends = $this->session->userdata('friend_ids');
        }
    }

    /**
     * Caching and fill the list of People you may know
     *
     */
    protected function update_people_you_may_know_list($isForce = false)
    {
        $pymk_list_last_update = $this->session->userdata('pymk_list_last_update');
        $pymk_list_cache_expiry_time = $this->config->item('pymk_list_cache_expiry_time');

        if (!$pymk_list_last_update || time() - $pymk_list_cache_expiry_time > $pymk_list_last_update || $isForce) {
            $this->load->model('users_m');
            $pymks = $this->users_m->get_people_user_may_know();
            $pymk_ids = array();
            if (!empty($pymks)) {
                foreach ($pymks as $pymk) {
                    $pymk_ids[] = $pymk->id;
                }
            }
            $this->pymk = $pymk_ids;
            $this->session->set_userdata(array('pymk_ids' => $pymk_ids, 'pymk_list_last_update' => time()));
        }
        else {
            $this->pymk = $this->session->userdata('pymk_ids');
        }

    }

    /**
     * Caching and fill user name
     *
     * @param bool $isForce
     */
    protected function update_user_name($isForce = false)
    {
        if (!$this->user) {
            $this->user = $this->ion_auth->where('Active', 1)->user()->row();
        }

        if ($this->session->userdata('my_name') && !$isForce) {
            $this->my_name = $this->session->userdata('user_name');
        }
        else {
            $this->my_name = $this->user->first_name . " " . $this->user->last_name;
            $this->session->set_userdata('my_name', $this->my_name);
        }
    }

    /**
     * Caching and fill user settings
     *
     * @param bool $isForce
     */
    protected function update_user_settings($isForce = false)
    {

        if ($this->session->userdata('my_settings') && !$isForce) {
            $this->my_settings = $this->session->userdata('my_settings');
        }
        else {
            $this->load->model('account_settings_m');
            $this->my_settings = $this->account_settings_m->get_account_settings();
            $this->session->set_userdata('my_settings', $this->my_settings);
        }
    }

    /**
     * Caching and fill user location
     *
     * @param bool $isForce
     */
    protected function update_user_location($isForce = false)
    {
        if (!$this->my_settings) {
            $this->update_user_settings();
        }

        if ($this->session->userdata('my_metroarea') && !$isForce) {
            $this->my_metroarea = $this->session->userdata('my_metroarea');
        }
        else {
            if ($this->my_settings && isset($this->my_settings->metroId)) {
                $this->load->model('location_m');
                $metroarea = $this->location_m->getById($this->my_settings->metroId);
                if ($metroarea) {
                    $this->my_metroarea = $metroarea->city;
                    $this->session->set_userdata('my_metroarea', $this->my_metroarea);
                }
            }
        }
    }

    protected function fill_banners(){
        if(!$this->my_metroarea && !$this->session->userdata('skip-banner:location')){
            $this->banner['location'] = 'Please go to the <a href="'.site_url('user/account_settings').'">account settings</a> and select your location.';
        }
    }

    protected function close_banner($type){
        if($this->banner[$type]){
            unset($this->banner[$type]);
            $this->session->set_userdata('skip-banner:'.$type, true);
        }
    }

    /**GETTERS*/
    public function get_banner_messages()
    {
        return $this->banner;
    }

    public function get_my_name()
    {
        return $this->user_name;
    }

    public function get_my_settings()
    {
        return $this->user_settings;
    }

    public function get_my_location_name()
    {
        return $this->user_metroarea;
    }

    public function get_user()
    {
        return $this->user;
    }

    public function get_friends()
    {
        return $this->friends;
    }

    public function get_pymk()
    {
        return $this->pymk;
    }
    /**END GETTERS*/

    protected function _render_page()
    {
        $this->data['messages_banner'] = $this->get_banner_messages();
        parent::_render_page();
    }

}

//Protocontroller for admin
class AdminController extends AuthController
{
    private $counters = array(
        'users' => 0,
        'future_events' => 0,
        'custom_future_events' => 0,
        'metroareas' => 0,
        'venues_list' => 0
    );

    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->in_group("admin")) {
            show_404();
        }
        $this->update_counters();

        $js_assets = array(
            array('bootstrap-table.js'),
        );
        $css_assets = array(
            array('admin/admin.css'),
            array('bootstrap-table.css'),
        );
        $this->carabiner->group('page_assets', array( 'js' => $js_assets, 'css' => $css_assets));

        $this->data['sub_layout'] = 'layouts/admin_page';
    }

    public function get_counters()
    {
        return $this->counters;
    }

    /**
     * Caching the list of People you may know
     *
     */
    protected function update_counters($isForce = false)
    {
        $counters_last_update = $this->session->userdata('counters_last_update');
        $counters_cache_expiry_time = $this->config->item('counters_cache_expiry_time');

        if (!$counters_last_update || time() - $counters_cache_expiry_time > $counters_last_update || $isForce) {
            $this->load->model('events_m');
            $this->load->model('venues_m');
            $this->load->model('location_m');
            $this->counters['users'] = $this->ion_auth->users()->num_rows();
            $this->counters['future_events'] = $this->events_m->get_total_count('future_events');
            $this->counters['custom_future_events'] = $this->events_m->get_total_count('custom_future_events');
            $this->counters['metroareas'] = $this->location_m->get_metroareas_total_count();
            $this->counters['venues_list'] = $this->venues_m->get_total_count();

            $this->session->set_userdata(array('counters' => $this->counters, 'counters_last_update' => time()));
        }
        else {
            $this->counters = $this->session->userdata('counters');
        }

    }

    protected function _render_page()
    {
        $this->data['counters'] = $this->get_counters();
        parent::_render_page();
    }

}

//Protocontroller for cron
class CronController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->input->is_cli_request()) {
            show_404();
        }
    }
}