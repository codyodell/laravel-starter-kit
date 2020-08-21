<?php

namespace App\Http\Controllers\Front;

use App\Components\Core\Menu\MenuItem;
use App\Components\Core\Menu\MenuManager;
use App\Components\User\Models\User;
use App\Http\Controllers\Front\FrontController;
use Illuminate\Support\Facades\Log;

class HomeController extends FrontController
{
    protected $nav;

    public function __construct()
    {
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
                'icon' => 'mdi-home',
                'route_type' => 'vue',
                'route_name' => 'home',
                'visible' => true,
            ]),
            new MenuItem([
                'group_requirements' => [],
                'label' => 'Login',
                'permission_requirements' => [],
                'nav_type' => MenuItem::$NAV_TYPE_NAV,
                'icon' => 'mdi-account',
                'route_type' => 'vue',
                'route_name' => 'login',
                'visible' => true,
            ]),
            new MenuItem([
                'nav_type' => MenuItem::$NAV_TYPE_DIVIDER
            ])
        ]);

        // view()->share('nav', $menuManager->getFiltered());
        $this->nav = $menuManager->getAll();
    }
    public function index()
    {
        $config = [
            'config' => $this->app_config,
            'nav' => $this->nav
        ];

        return view('front.home', $config);
    }
}
