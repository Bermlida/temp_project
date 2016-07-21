<?php

namespace App\Models\Helpers\CommonHelpers;

if (! function_exists('hello_world')) {
    /**
     * helper function 1
     * 
     * @return string
     */
    function hello_world(string $data)
    {
        return $data . "Hello World";
    }
}

if (! function_exists('assss_world')) {
    /**
     * helper function 2
     * 
     * @return string
     */
    function assss_world(string $string, string $string2)
    {
        return  $string . " Aspen~~~~~~~~ " . $string2;
    }
}