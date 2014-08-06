<?php

if (!function_exists('is_logged_in')) {
    function is_logged_in()
    {
        $CI = & get_instance();
        return $CI->ion_auth->logged_in();
    }
}

if (!function_exists('get_user_name')) {
    function get_user_name()
    {
        $CI = & get_instance();
        return $CI->session->userdata('my_name')?$CI->session->userdata('my_name'):'Member';
    }
}

if (!function_exists('is_admin')) {
    function is_admin()
    {
        $CI = & get_instance();
        return $CI->ion_auth->in_group("admin");
    }
}