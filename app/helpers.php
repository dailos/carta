<?php

if (! function_exists('form_value')) {
	function form_value($value, $field, $errors)
	{
		if (isset($value) && !$errors->any()) {
			return $value;
		} else {
			return old($field);
		}
	}
}

if (! function_exists('key_length')) {

    function key_length($a, $b) {

        return strlen($a) >= strlen($b) ? 1 : -1;

    }

}

if (! function_exists('is_json')) {
    function is_json($string,$return_data = false) {
        $data = json_decode($string, true);
        return (json_last_error() == JSON_ERROR_NONE) ? ($return_data ? $data : TRUE) : FALSE;
    }
}

if (! function_exists('uksort_walk')) {
	function uksort_walk(&$elemento, $clave)
    {
        if ($elemento) {
            uksort($elemento, "key_length");
        }
    }
}

if (! function_exists('index_sort')) {
	function index_sort($array, $order = false)
    {
        $order ? $sorted = array_values($array) : $sorted = $array;
	    return array_walk($sorted, 'uksort_walk') ? $sorted : FALSE;
    }
}