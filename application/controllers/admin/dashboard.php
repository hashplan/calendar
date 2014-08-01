<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $js_assets = array(
            array('admin/dashboard.js'),
            array('event_search.js'),
            array('user_added_event_form.js'),
            array('event_modal.js'),
        );
        $css_assets = array(
            array('admin/dashboard.css'),
            array('event.css'),
            array('event_modal.css'),
        );
        $this->carabiner->group('page_assets', array('js' => $js_assets, 'css' => $css_assets) );
    }

    public function index()
    {
        $this->data['view'] = 'admin/dashboard/index';
        $this->data['counters'] = $this->get_counters();
        /*$counters = $this->get_counters();
        echo "<pre>";
        var_dump($counters);
        echo "</pre>";*/
        $this->_render_page();
    }

    public function users()
    {
        /*$this->data['users_count'] = $this->ion_auth->users()->count();
        foreach ($this->data['users'] as $k => $user) {
            $this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
        }
        $this->data['subview'] = 'auth/index';
        $this->load->view('_layout_admin', $this->data);*/
    }


    public function events()
    {
        /*$this->data['events'] = $this->events_m->get();
        $this->data['cal'] = $this->calendar();
        $this->data['subview'] = 'admin/dashboard/index';
        $this->load->view('admin/_layout_main', $this->data);*/
    }

}