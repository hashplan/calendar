<?php
/**
 * Form Declaration - Multipart type
 *
 * Creates the opening portion of the form, but with "multipart/form-data".
 *
 * @access    public
 * @param    string    the URI segments of the form destination
 * @param    array    a key/value pair of attributes
 * @param    array    a key/value pair hidden data
 * @return    string
 */
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