<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\FrontController;
use Illuminate\Support\Facades\Log;

class HomeController extends FrontController
{
    public function index()
    {
        $config = [
            'config' => $this->app_config,
            'nav' => $this->nav
        ];

        return view('front.home', $config);
    }
}
