<?php

namespace App\Providers;

use App\View\Components\layouts\Head;
use App\View\Components\layouts\Logo;
use Illuminate\Support\Facades\Blade;
use App\View\Components\Layouts\Footer;
use App\View\Components\layouts\Navbar;
use Illuminate\Support\ServiceProvider;
use App\View\Components\Layouts\Setting;
use App\View\Components\layouts\Sidebar;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // View::composer('components.layouts.sidebar', function ($view) {
        //     $menus = Menu::whereNull('parent_id')
        //         ->with('submenus.subsubmenus')
        //         ->orderBy('ordering')
        //         ->get();
        //     $view->with('menus', $menus);
        // });

        Blade::component('components.layouts.navbar', Navbar::class);
        Blade::component('components.layouts.sidebar', Sidebar::class);
        Blade::component('components.layouts.footer', Footer::class);
        Blade::component('components.layouts.logo', Logo::class);
        Blade::component('components.layouts.head', Head::class);
        Blade::component('components.layouts.setting', Setting::class);
    }
}
