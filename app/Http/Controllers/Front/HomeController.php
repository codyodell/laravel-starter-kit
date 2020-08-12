<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;

class HomeController extends FrontController
{
    public function index()
    {
        return view('home');
    }
}
