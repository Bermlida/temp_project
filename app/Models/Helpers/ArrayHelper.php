<?php

namespace App\Models\Helpers;

if (! function_exists('array_show')) {
    /**
     * dump array
     * 
     * @return string
     */
    function array_show(array $data)
    {
        return var_dump($data, true);
    }
}