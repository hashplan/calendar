<?php

if (!function_exists('field_error_class')) {
    function field_error_class($field_name = '', $class = 'has-error')
    {
        $result = '';
        if (form_error($field_name)) {
            $result = $class;
        }
        return $result;
    }
}