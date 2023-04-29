<?php

namespace Module\Index;

use App\Core\Request;
use App\Core\View;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index(Request $request)
    {

        View::view("index");
    }
}
