<?php

namespace App\Interfaces;

interface MiddlewareRequest
{
    public function before();

    public function after();
}
