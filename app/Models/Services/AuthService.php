<?php

namespace App\Models\Services;

class AuthService
{
    public function __construct($message = '')
    {
        print "message:::::" . $message . '<br>';
    }

    public function callMe($controller)
    {
        print 'Call Me From TestServiceProvider In ' . $controller;
    }
}