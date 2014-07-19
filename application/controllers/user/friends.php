<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Friends extends AuthController
{

    public $data = array(
        'sub_layout' => 'layouts/user_page',
    );
    public $user = NULL;
    public $my_friends_ids = array();
    protected $typesView = array(
        'friends' => 'friends_list',
        'friends_invites' => 'invites_list',
        'events_invites' => 'invites_list',
        'invites_sent' => 'invites_list',
        'add_friends' => 'users_list',
        'user_friends' => 'users_friends_list',
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->model('users_m');
        $js_assets = array(
            array('friends_search'),
            array('people_you_may_know'),
        );
        $css_assets = array(
            array('friend.css'),
        );
        $this->carabiner->group('page_assets', array('js' => $js_assets, 'css' => $css_assets) );
    }

    public function index()
    {
        $user_id = $this->ion_auth->user()->row()->id;
        Menu::setActive('user/friends/friends_current');
        $page_class = 'friends';
        $page_title = 'Current friends';
        $page_type = 'friends';
        $this->load->model('location_m');
        $users = $this->users_m->get_friends();
        $locations = $this->location_m->get_left_block_metro_areas();
        $left_block = $this->load->view('user/friends/locations_left_block', array('locations' => $locations, 'user_id' => $user_id), TRUE);
        $this->_render_users_page($page_class, $page_title, $page_type, $left_block, $users);
    }

    public function friend($user_id = null)
    {
        if ($user_id == $this->ion_auth->user()->row()->id) {
            redirect('user/friends');
        }
        Menu::setActive('user/friends/friends_current');
        $page_class = 'friends';
        $page_title = 'Current friends';
        $page_type = 'user_friends';
        $this->load->model('location_m');
        $users = $this->users_m->get_friends(array('user_id' => $user_id));
        $locations = $this->location_m->get_left_block_metro_areas();
        $left_block = $this->load->view('user/friends/locations_left_block', array('locations' => $locations, 'user_id' => $user_id), TRUE);
        $this->_render_users_page($page_class, $page_title, $page_type, $left_block, $users);
    }

    public function add()
    {
        $user_id = $this->ion_auth->user()->row()->id;
        Menu::setActive('user/friends/friends_add');
        $page_class = 'add-friend';
        $page_title = 'Add friends';
        $page_type = 'add_friends';
        $this->load->model('location_m');
        $users = $this->users_m->get_unknown_users();
        $locations = $this->location_m->get_left_block_metro_areas();
        $left_block = $this->load->view('user/friends/locations_left_block', array('locations' => $locations, 'user_id' => $user_id), TRUE);

        $this->_render_users_page($page_class, $page_title, $page_type, $left_block, $users);
    }

    public function users_list()
    {
        $post = $this->input->post();
        $options = array();
        if (!empty($post['offset'])) {
            $options['offset'] = (int)$post['offset'];
        }
        if (!empty($post['name']) && strlen(trim($post['name']))) $options['name'] = trim($post['name']);
        $options['location_ids'] = empty($post['location_ids']) ? array('all') : $post['location_ids'];
        if (!empty($post['location_name'])) {
            $options['location_name'] = $post['location_name'];
        }
        $users = $this->users_m->get_unknown_users($options);
        $users_ids = array();
        foreach ($users as $user) {
            $users_ids[] = $user->id;
        }

        $mutual_friends_count = $this->users_m->get_mutual_friends_count($users_ids, $this->friends);
        foreach ($users as $user) {
            $user->mutual_friends_count = !empty($mutual_friends_count[$user->id]) ? $mutual_friends_count[$user->id] : 0;
        }

        $this->load->view('user/friends/users_list', array('people' => $users, 'page_type' => 'add_friends'));
    }

    public function invites($invite_type = NULL)
    {
        Menu::setActive('user/invites');

        /*$post = $this->input->post();
        $options = array();
        if (!empty($post['name']) && strlen(trim($post['name']))) $options['name'] = trim($post['name']);
        $options['location_ids'] = empty($post['location_ids']) ? array('all') : $post['location_ids'];
        if (!empty($post['location_name'])) {
            $options['location_name'] = $post['location_name'];
        }
        if (!empty($post['offset'])) {
            $options['offset'] = (int)$post['offset'];
        }
        $options['user_id'] = $this->user->id;*/

        $users_which_sent_friend_request = $this->users_m->get_users_which_sent_friend_request();
        $users_which_sent_event_invite = $this->users_m->get_users_which_sent_event_invite();
        $users_you_sent_friend_request = $this->users_m->get_users_you_sent_friend_request();
        $users_you_sent_event_invite = $this->users_m->get_users_you_sent_event_invite();
        $users_you_sent_invites = array_merge($users_you_sent_friend_request, $users_you_sent_event_invite);
        $counts = array(
            'received_friend_requests' => count($users_which_sent_friend_request),
            'received_event_invites' => count($users_which_sent_event_invite),
            'sent_invites' => count($users_you_sent_invites),
        );

        if ($invite_type === 'sent') {
            $this->_invites_sent($users_you_sent_invites, $counts);
        } else if ($invite_type === 'events') {
            $this->_invites_events($users_which_sent_event_invite, $counts);
        } else {
            $this->_invites_received($users_which_sent_friend_request, $counts);
        }
    }

    protected function _invites_received($users, $counts)
    {
        $page_class = 'invites';
        $page_title = 'Invites to connect with friends';
        $page_type = 'friends_invites';
        $left_block = $this->load->view('user/friends/invites_left_block', array('counts' => $counts), TRUE);
        $this->_render_users_page($page_class, $page_title, $page_type, $left_block, $users);
    }

    protected function _invites_events($users, $counts)
    {
        $page_class = 'invites';
        $page_title = 'Invites to visit events';
        $page_type = 'events_invites';
        $left_block = $this->load->view('user/friends/invites_left_block', array('counts' => $counts), TRUE);
        $this->_render_users_page($page_class, $page_title, $page_type, $left_block, $users);
    }

    protected function _invites_sent($users, $counts)
    {
        $page_class = 'invites';
        $page_title = 'Sent invites';
        $page_type = 'invites_sent';
        $left_block = $this->load->view('user/friends/invites_left_block', array('counts' => $counts), TRUE);
        $this->_render_users_page($page_class, $page_title, $page_type, $left_block, $users);
    }

    public function friends_list($user_id = null)
    {
        $post = $this->input->post();
        $options = array();
        if (!empty($post['name']) && strlen(trim($post['name']))) $options['name'] = trim($post['name']);
        $options['location_ids'] = empty($post['location_ids']) ? array('all') : $post['location_ids'];
        if (!empty($post['location_name'])) {
            $options['location_name'] = $post['location_name'];
        }
        if (!empty($post['offset'])) {
            $options['offset'] = (int)$post['offset'];
        }
        if (!is_null($user_id)) {
            $options['user_id'] = $user_id;
        }

        if ($this->user->id == $user_id) {
            $user_all_friends_ids = $this->friends;
        } else {
            $user_all_friends = $this->users_m->get_friends(array('user_id' => $user_id), true);
            $user_all_friends_ids = array();
            if (!empty($user_all_friends)) {
                foreach ($user_all_friends as $friend) {
                    $user_all_friends_ids[] = $friend->id;
                }
            }
        }

        $user_friends_after_filter = $this->users_m->get_friends($options);
        $user_friends_ids_after_filter = array();
        foreach ($user_friends_after_filter as $friend) {
            $user_friends_ids_after_filter[] = $friend->id;
        }

        $user_mutual_friends_count = $this->users_m->get_mutual_friends_count($user_friends_ids_after_filter, $user_all_friends_ids);
        foreach ($user_friends_after_filter as $friend) {
            $friend->mutual_friends_count = !empty($user_mutual_friends_count[$friend->id]) ? $user_mutual_friends_count[$friend->id] : 0;
        }

        $this->load->view('user/friends/friends_list', array('people' => $user_friends_after_filter, 'page_type' => 'friends', 'current_user_id' => $user_id, 'my_friends' => $this->friends));
    }

    public function inviters_list()
    {
        $post = $this->input->post();
        $options = array();
        if (!empty($post['name']) && strlen(trim($post['name']))) $options['name'] = trim($post['name']);

        $friends_after_filter = $this->users_m->get_users_which_sent_friend_request($options);
        $friends_after_filter_ids = array();
        foreach ($friends_after_filter as $friend) {
            $friends_after_filter_ids[] = $friend->id;
        }

        $mutual_friends_count = $this->users_m->get_mutual_friends_count($friends_after_filter_ids, $this->friends);
        foreach ($friends_after_filter as $friend) {
            $friend->mutual_friends_count = !empty($mutual_friends_count[$friend->id]) ? $mutual_friends_count[$friend->id] : 0;
        }

        $this->load->view('user/friends/friends_list', array('people' => $friends_after_filter, 'page_type' => 'friends_invites'));
    }

    public function inviters_events_list()
    {
        $post = $this->input->post();
        $options = array();
        if (!empty($post['name']) && strlen(trim($post['name']))) $options['name'] = trim($post['name']);

        $inviters_after_filter = $this->users_m->get_users_which_sent_event_invite($options);
        $inviters_after_filter_ids = array();
        foreach ($inviters_after_filter as $inviter) {
            $inviters_after_filter_ids[] = $inviter->id;
        }

        $mutual_friends_count = $this->users_m->get_mutual_friends_count($inviters_after_filter_ids, $this->friends);
        foreach ($inviters_after_filter as $inviter) {
            $inviter->mutual_friends_count = !empty($mutual_friends_count[$inviter->id]) ? $mutual_friends_count[$inviter->id] : 0;
        }

        $this->load->view('user/friends/friends_list', array('people' => $inviters_after_filter, 'page_type' => 'events_invites'));
    }

    public function invited_list()
    {
        $post = $this->input->post();
        $options = array();
        if (!empty($post['name']) && strlen(trim($post['name']))) $options['name'] = trim($post['name']);

        $friend_request_receivers = $this->users_m->get_users_you_sent_friend_request($options);
        $friend_request_receivers_after_filter_ids = array();
        foreach ($friend_request_receivers as $receiver) {
            $friend_request_receivers_after_filter_ids[] = $receiver->id;
        }
        $receiver = NULL;

        $mutual_friends_count = $this->users_m->get_mutual_friends_count($friend_request_receivers_after_filter_ids, $this->friends);
        foreach ($friend_request_receivers as $receiver) {
            $receiver->mutual_friends_count = !empty($mutual_friends_count[$receiver->id])
                ? $mutual_friends_count[$receiver->id]
                : 0;
        }
        $receiver = NULL;

        $event_invite_receivers = $this->users_m->get_users_you_sent_event_invite($options);
        $event_invite_receivers_after_filter_ids = array();
        foreach ($event_invite_receivers as $receiver) {
            $event_invite_receivers_after_filter_ids[] = $receiver->id;
        }
        $receiver = NULL;

        $mutual_friends_count = $this->users_m->get_mutual_friends_count($event_invite_receivers_after_filter_ids, $this->friends);
        foreach ($event_invite_receivers as $receiver) {
            $receiver->mutual_friends_count = !empty($mutual_friends_count[$receiver->id]) ? $mutual_friends_count[$receiver->id] : 0;
        }

        $people = array_merge($friend_request_receivers, $event_invite_receivers);

        $this->load->view('user/friends/friends_list', array('people' => $people, 'page_type' => 'invites_sent'));
    }

    public function people_you_may_know_list()
    {
        $post = $this->input->post();
        $options = array();
        if (!empty($post['name']) && strlen(trim($post['name']))) $options['name'] = trim($post['name']);
        $options['location_ids'] = empty($post['location_ids']) ? array('all') : $post['location_ids'];
        if (!empty($post['location_name'])) {
            $options['location_name'] = $post['location_name'];
        }
        $people_after_filter = $this->users_m->get_people_user_may_know($options);
        $people_after_filter_ids = array();
        foreach ($people_after_filter as $friend) {
            $people_after_filter_ids[] = $friend->id;
        }

        $mutual_friends_count = $this->users_m->get_mutual_friends_count($people_after_filter_ids, $this->friends);
        foreach ($people_after_filter as $friend) {
            $friend->mutual_friends_count = !empty($mutual_friends_count[$friend->id]) ? $mutual_friends_count[$friend->id] : 0;
        }

        $this->load->view('user/friends/friends_list', array('people' => $people_after_filter, 'page_type' => 'add_friends'));
    }

    public function people_you_may_know_block()
    {
        $people_you_may_know = $this->users_m->get_people_user_may_know();
        foreach ($people_you_may_know as $dude) {
            $dude->name = $this->users_m->generate_full_name($dude);
        }
        $this->load->view('user/friends/people_you_may_know_block', array('people_you_may_know' => $people_you_may_know));
    }

    public function remove_from_lists($user_id)
    {
        if ($this->users_m->user_id_is_correct($user_id)) {
            $this->users_m->delete_connection_between_users($user_id, NULL);
            $this->users_m->set_connection_between_users($user_id, NULL, NULL, 'removed');
            if (!$this->input->is_ajax_request()) {
                redirect(base_url() . 'user/friends');
            }
        }
    }

    public function remove_from_contact($user_id)
    {
        if ($this->users_m->user_id_is_correct($user_id)) {
            $this->users_m->delete_connection_between_users($user_id, NULL);
            if (!$this->input->is_ajax_request()) {
                redirect(base_url() . 'user/friends');
            }
        }
    }

    public function friend_request($friend_id = NULL)
    {
        if($this->users_m->set_connection_between_users($friend_id, NULL, NULL, 'friend_request')){
            $this->load->library('email');
            $to = $this->ion_auth->user($friend_id)->row();
            $from = $this->ion_auth->user()->row();
            $this->email->send_friend_invite_email($from, $to);
        }
        redirect('user/friends/add');
    }

    public function friend_accept($friend_id = NULL)
    {
        if($this->users_m->set_connection_between_users($friend_id, NULL, 'friend_request', 'friend')){
            $this->update_friend_list(true);
        }
        redirect('user/friends/invites');
    }

    public function event_invite_accept($inviter_id, $event_id)
    {
        $this->users_m->set_connection_between_users($inviter_id, NULL, 'event_invite', 'event_invite_accept', $event_id);
        // todo: moar logic
        redirect('user/friends/invites/events');
    }

    public function locations_autocomplete()
    {
        $this->load->model('location_m');
        $locations_raw = $this->location_m->get_all_metro_areas();
        $locations = array();
        foreach ($locations_raw as $location) {
            $locations[] = array('id' => $location->id, 'city' => $location->city);
        }
        header('Content-Type: application/json');
        echo json_encode($locations);
        die();
    }

    protected function _render_users_page($page_class, $page_title, $page_type, $left_block, $users)
    {
        $this->data['page_class'] = $page_class;
        $this->data['view'] = $this->get_user_identifier() . '/friends/users';
        $this->data['data']['page_title'] = $page_title;
        $this->data['data']['page_type'] = $page_type;
        $this->data['data']['left_block'] = $left_block;
        $this->data['user'] = $this->user;

        $users_ids = array();
        foreach ($users as $user) {
            $users_ids[] = $user->id;
        }

        $mutual_friends_count = $this->users_m->get_mutual_friends_count($users_ids, $this->friends);
        foreach ($users as $user) {
            $user->mutual_friends_count = !empty($mutual_friends_count[$user->id]) ? $mutual_friends_count[$user->id] : 0;
        }

        $people_you_may_know = $this->users_m->get_people_user_may_know();
        foreach ($people_you_may_know as $dude) {
            $dude->name = $this->users_m->generate_full_name($dude);
        }
        $this->data['data']['people_you_may_know_block'] = $this->load->view('user/friends/people_you_may_know_block', array('people_you_may_know' => $people_you_may_know), TRUE);
        $users_list = $this->load->view('user/friends/' . $this->typesView[$page_type], array('people' => $users, 'page_type' => $page_type, 'my_friends' => $this->friends), TRUE);
        $this->data['data']['users_list'] = $users_list;

        $this->_render_page();
    }

    public function send_multiple_event_invites()
    {
        $post = $this->input->post();
        $friend_ids = !empty($post['friend_ids']) ? $post['friend_ids'] : NULL;
        $event_id_is_correct = $post['event_id'] !== NULL && is_numeric($post['event_id']) && $post['event_id'] > 0;
        if ($friend_ids === NULL || !$event_id_is_correct) {
            return;
        }
        foreach ($friend_ids as $friend_id) {
            $this->users_m->set_connection_between_users($friend_id, NULL, NULL, 'event_invite', $post['event_id']);
        }
    }

}