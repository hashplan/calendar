<?php

function btn_edit($uri)
{
    return anchor($uri, '<span class ="glyphicon glyphicon-edit"></span');
}

function btn_delete($uri)
{
    return anchor($uri, '<i class ="glyphicon glyphicon-remove"></i>', array('onclick' => "return confirm('You are about to delete and this can not be undone');"));
}

/**
 * Dump helper. Functions to dump variables to the screen, in a nicely formatted manner.
 * @author Joost van Veen
 * @version 1.0
 */
if (!function_exists('dump')) {
    function dump($var, $label = 'Dump', $echo = TRUE)
    {
        // Store dump in variable
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        // Add formatting
        $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
        $output = '<pre style="background: #FFFEEF; color: #000; border: 1px dotted #000; padding: 10px; margin: 10px 0; text-align: left;">' . $label . ' => ' . $output . '</pre>';
        // Output
        if ($echo == TRUE) {
            echo $output;
        } else {
            return $output;
        }
    }
}


if (!function_exists('dump_exit')) {
    function dump_exit($var, $label = 'Dump', $echo = TRUE)
    {
        dump($var, $label, $echo);
        exit;
    }
}

if (!function_exists('display_notification')) {
    function display_notification()
    {
        $CI = & get_instance();

        $message = '';
        $class = "alert alert-success fade in";
        if ($CI->session->flashdata('flash_message_type') == 'warning') {
            $class = "alert alert-warning fade in";
        } elseif ($CI->session->flashdata('flash_message_type') == 'error') {
            $class = "alert alert-danger fade in";
        }

        if($CI->session->flashdata('flash_message')){
            $message = '<div class="' . $class . '">' . $CI->session->flashdata('flash_message') . '</div>';
        }

        return $message;
    }
}