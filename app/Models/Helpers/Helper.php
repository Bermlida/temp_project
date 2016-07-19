<?php

namespace App\Models\Helpers;

class Helper
{
    private $storage;

    public function __construct($storage = null, array $processor = [])
    {
        $this->storage = $storage;
        foreach ($processor as $function => $arguments) {
            $this->__call($function, (array)$arguments);
        }
    }

    public function __get($name) 
    {
        if ($name == "result") {
            return $this->storage;
        }
        return null;
    }

    public function __call($name, $arguments) 
    {
        $name = __NAMESPACE__ . '\\' . $name;
        if (function_exists($name)) {
            if (!is_null($this->storage)) {
                array_unshift($arguments, $this->storage);
            }

            $return = call_user_func_array($name, $arguments);
            $this->storage = $return ?? $this->storage;
            return $this;
        }
        throw new \RuntimeException('Helper function not found. function name is ' . $name);
    }

    public static function __callStatic($name, $arguments) 
    {
        $name = __NAMESPACE__ . '\\' . $name;
        if (function_exists($name)) {
            return call_user_func_array($name, $arguments);
        }
        throw new \RuntimeException('Helper function not found. function name is ' . $name);
    }
}
