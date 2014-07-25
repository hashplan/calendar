<?php

if (!function_exists('is_logged_in')) {
    function is_logged_in()
    {
        $CI = & get_instance();
        return $CI->ion_auth->logged_in();
    }
}