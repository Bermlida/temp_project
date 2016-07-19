<?php

namespace App\Models\Helpers;

class Helper
{
    private $prev_result;

    public function __get($name) 
    {
        if ($name == "result") {
            return $this->prev_result;
        }
        return null;
    }

    public function __call($name, $arguments) 
    {
        $name = __NAMESPACE__ . '\\' . $name;
        if (!is_null($this->prev_result)) {
            array_unshift($arguments, $this->prev_result);
        }
        $this->prev_result = call_user_func_array($name, $arguments);
        return $this;
    }

    public static function __callStatic($name, $arguments) 
    {
        $name = __NAMESPACE__ . '\\' . $name;
        return call_user_func_array($name, $arguments);
    }
}
