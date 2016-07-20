<?php

namespace App\Models\Facades;

use \ReflectionClass;
use Illuminate\Support\Facades\Facade as BaseFacade;

abstract class Facade extends BaseFacade
{
    protected static function getFacadeAccessor()
    {
        $name = (new ReflectionClass(new static))->getShortName();
        return str_replace("Facade", "", $name);
    }

    protected static function resolveFacadeInstance($name)
    {
        if (is_string($name)) {
            preg_match('/\S+(Repository|Library|Helper)$/', $name, $matches);
            if (count($matches) > 0) {
                $type = $matches[1];
                switch ($type) {
                    case "Repository":
                        $namespace = "App\\Models\\Repositories\\";
                        break;
                    case "Library":
                        $namespace = "App\\Models\\Libraries\\";
                        break;
                    case "Helper":
                        $name = "Helper";
                        $namespace = "App\\Models\\Helpers\\";
                        break;
                    default: break;
                }
                $name = $namespace . $name;
                return new $name;
            }
        }

        return parent::resolveFacadeInstance($name);
    }
}
