<?php

namespace App\Models\Repositories;

abstract class Repository
{
    public function __construct()
    {
        $class = new \ReflectionClass($this);
        $properties = $class->getProperties(\ReflectionProperty::IS_PROTECTED);
        foreach ($properties as $property) {
            $property->setAccessible(true);
            $property_name = $property->getName();
            $property_value = $property->getValue($this);

            if (!is_string($property_value)) {
                $segments = explode("_", $property_name);
                if (count($segments) > 1) {
                    $callback = function ($name) {
                        return ucfirst(strtolower($name));
                    };
                }  else {
                    $callback = "ucfirst";
                }
                $property_value = implode(array_map($callback, $segments));
            }

            $namespace = (strpos($property_value, "\\") === false) ? "App\\Models\\Repositories\\Entities\\" : "";
            $property_value = $namespace . $property_value;
            $this->$property_name = new $property_value;
        }
    }

    public function __get($name) 
    {
        if (isset($this->$name) && is_object($this->$name)) {
            $class = new \ReflectionClass($this);
            $property = $class->getProperty($name);

            if ($property->isProtected()) {
                $property->setAccessible(true);
                $property_value = $property->getValue($this);
                
                $property_parents = array();
                $property_class = new \ReflectionClass($property_value);
                while ($property_parent = $property_class->getParentClass()) {
                    $property_parents[] = $property_parent->getName();
                    $property_class = $property_parent;
                }

                if (in_array("Illuminate\\Database\\Eloquent\\Model", $property_parents)) {
                    $db_driver = $property_value;

                    return new class($db_driver) {
                        private $db_driver;

                        public function __construct($db_driver)
                        {
                            $this->db_driver = $db_driver;
                        }

                        public function create(array $data)
                        {
                            $class_name = get_class($this->db_driver);
                            $entity = new $class_name;
                            foreach ($data as $key => $value) {
                                $entity->$key = $value;
                            }
                            $entity->save();
                            return $entity;
                        }

                        public function delete(int $id)
                        {
                            $entity = $this->db_driver->find($id);
                            if (!is_null($entity)) {
                                $entity->delete();
                            }
                        }

                        public function update(array $data, int $id)
                        {
                            $entity = $this->db_driver->find($id);
                            if (!is_null($entity)) {
                                foreach ($data as $key => $value) {
                                    $entity->$key = $value;
                                }
                                $entity->save();
                            }
                            return $entity;
                        }

                        public function read(int $id)
                        {
                            $entity = $this->db_driver->find($id);
                            return $entity;
                        }
                    };
                }
            }
        }
        return null;
    }
}