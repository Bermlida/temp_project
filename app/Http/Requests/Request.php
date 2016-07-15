<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    public function response(array $errors)
    {
        return parent::response($errors);
    }

    public function forbiddenResponse()
    {
        return parent::forbiddenResponse();
    }

    public function messages()
    {
        return parent::messages();
    }

    public function attributes()
    {
        return parent::attributes();
    }
}
