<?php

namespace App\Http\Controllers\Front;

# use Illuminate\Http\Request;
# use Illuminate\Support\Facades\Blade;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Components\User\Models\User;

class HomeController extends FrontController
{
    public function index()
    {
        $currentUeeser = \Auth::user();

        view()->share('current_user', $currentUser);

        return view('layouts.front');
    }
}
