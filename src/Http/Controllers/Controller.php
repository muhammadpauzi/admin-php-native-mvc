<?php

namespace App\Http\Controllers;

use App\Core\Database;

class Controller
{
    protected Database $database;

    public function __construct()
    {
        $this->database = new Database();
    }
}
