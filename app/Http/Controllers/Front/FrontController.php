<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
# use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;

class FrontController extends Controller
{
    protected $app_config;

    /**
     * Class constructor.
     */
    public function __construct(array $app_config = [])
    {
        $__app_config = [
            'locale' => str_replace('_', '-', app()->getLocale()),
            'name' => config('app.name'),
            'description' => config('app.description'),
            'URL' => config('app.url'),
            'authenticated' => \Auth::check(),
            'currrent_user' => false,
            'page_meta' => [
                'title' => null,
                'subtitle' => null,
            ]
        ];

        if ($__app_config['authenticated']) {
            $__app_config['currrent_user'] = \Auth::user();
        }

        $this->app_config = array_merge($__app_config, $app_config);
    }

    public function config(string $dotPath = '')
    {
        $val = false;
        if (Arr::has($this->app_config, $dotPath)) {
            $val = Arr::get($dotPath, $this->app_config);
        }
        return $val;
    }
}
