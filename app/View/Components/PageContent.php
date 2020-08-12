<?php

namespace App\View\Components;

use Illuminate\View\Component;
# use Illuminate\Support\Facades\Blade;

class PageContent extends Component
{
    public function __construct()
    {
        //
    }

    public function render()
    {
        return view('components.page-content');
    }
}
