<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Components\Core\Menu\MenuItem;
use App\Components\Core\Menu\MenuManager;
use App\Components\User\Models\User;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Arr;

class FrontController extends Controller
{
    // use AuthenticatesUsers;

    protected $nav;
    protected $app_config;

    /**
     * Class constructor.
     */
    public function __construct(array $app_config = [])
    {

        // $this->middleware('guest')->except('logout');

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

        view()->share('app_config', array_merge($__app_config, $app_config));

        Log::info($this->config('name'));

        $menuManager = new MenuManager();

        if (@$this->app_config['current_user']) {
            $menuManager->setUser($this->app_config['current_user']);
        }

        $menuManager->addMenus([
            new MenuItem([
                'group_requirements' => [],
                'label' => 'Home',
                'permission_requirements' => [],
                'nav_type' => MenuItem::$NAV_TYPE_NAV,
                'icon' => 'home',
                'route_type' => 'vue',
                'route_name' => 'front.home',
                'visible' => true,
            ]),
            new MenuItem([
                'group_requirements' => [],
                'label' => 'Login',
                'permission_requirements' => [],
                'nav_type' => MenuItem::$NAV_TYPE_NAV,
                'icon' => 'account',
                'route_type' => 'vue',
                'route_name' => 'auth.login',
                'visible' => true,
            ]),
            new MenuItem([
                'nav_type' => MenuItem::$NAV_TYPE_DIVIDER
            ])
        ]);

        view()->share('nav', $menuManager->getFiltered());
        // $this->nav = $menuManager->getFiltered();
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
