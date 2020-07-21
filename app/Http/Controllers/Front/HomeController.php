<?php

namespace App\Http\Controllers\Front;

use App\User;

class HomeController extends FrontController
{
    public function index()
    {
        return view('welcome');
    }
}
