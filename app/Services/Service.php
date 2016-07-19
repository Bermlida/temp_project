<?php

namespace App\Services;

abstract class Service
{

    protected $result_flag;
    protected $result_data;
    protected $result_message;

    public function toObject()
    {
        $result = new \stdClass();

        if (is_bool($this->result_flag))
            $result->flag = $this->result_flag;
        if (is_string($this->result_message))
            $result->message = $this->result_message;
        if (!is_null($this->result_data))
            $result->data = $this->result_data;

        return $result;
    }

    public function toArray()
    {
        $result = $this->toObject();
        return (array)($result);
    }

    public function toJson()
    {
        $result = $this->toObject();
        return json_encode($result);
    }

    public function __toString()
    {
        return $this->toJson();
    }

    public function __get($name)
    {
        if($name == 'result'){
            return $this->toObject();
        }
        return null;
    }
}

/* End of file Service.php */
/* Location: .//home/tkb-user/projects/laravel/app/Services/Service.php */