<?php

namespace Helpers;

class Filter{

    /**
     * Checks if given method is available and then sanitizes it 
     *
     * @param string $input
     * @return bool
     */
    public function checkMethod($input){
        return (
            filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_SPECIAL_CHARS) === strtoupper($input) 
        ) ? true : false;
    }

    /**
     * Returns sanitized array given from param
     *
     * @param array $arr
     * @return void
     */
    public function sanitizeArray($arr){
        return filter_input_array(strtoupper($arr), FILTER_SANITIZE_SPECIAL_CHARS);
    }

}
