<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;

class SidebarController extends Controller
{
    public function getMenus()
    {
        // Mendapatkan menu dari cache
        $menus = Cache::remember('menus', 60, function () {
            return Menu::whereNull('parent_id')
                ->with('submenus.submenus')
                ->orderBy('ordering')
                ->get();
        });

        // Mendapatkan current path dari request
        $currentPath = request()->path();
        // Mendapatkan category_id dari query string, jika ada
        $categoryId = request()->query('category_id');

        // Menemukan menu aktif berdasarkan route dan category_id
        $activeMenu = $menus->firstWhere(function ($menu) use ($currentPath, $categoryId) {
            // Cek jika route menu cocok dengan path saat ini dan category_id sesuai (jika ada)
            return $menu->route === $currentPath || request()->is($menu->route . '/*') && ($menu->category_id == $categoryId || $categoryId === null);
        });

        // Menemukan submenu aktif berdasarkan route dan category_id
        $activeSubmenu = $activeMenu ? $activeMenu->submenus->firstWhere(function ($submenu) use ($currentPath, $categoryId) {
            // Cek jika route submenu cocok dengan path saat ini dan category_id sesuai (jika ada)
            return $submenu->route === $currentPath || request()->is($submenu->route . '/*') && ($submenu->category_id == $categoryId || $categoryId === null);
        }) : null;

        // Menemukan subsubmenu aktif berdasarkan route dan category_id
        $activeSubSubmenu = $activeSubmenu ? $activeSubmenu->submenus->firstWhere(function ($subsubmenu) use ($currentPath, $categoryId) {
            // Cek jika route subsubmenu cocok dengan path saat ini dan category_id sesuai (jika ada)
            return $subsubmenu->route === $currentPath || request()->is($subsubmenu->route . '/*') && ($subsubmenu->category_id == $categoryId || $categoryId === null);
        }) : null;

        // Mengembalikan tampilan dengan data yang diperlukan
        return view('components.layouts.sidebar', compact('menus', 'activeMenu', 'activeSubmenu', 'activeSubSubmenu'));
    }



    // public function getMenus()
    // {
    //     $menus = Cache::remember('menus', 60, function () {
    //         return Menu::whereNull('parent_id')
    //             ->with('submenus.submenus')
    //             ->orderBy('ordering')
    //             ->get();
    //     });

    //     $activeMenu = $menus->firstWhere('route', request()->path());
    //     $activeSubmenu = $activeMenu->submenus->firstWhere('route', request()->path()) ?? null;
    //     $activeSubSubmenu = $activeSubmenu->submenus->firstWhere('route', request()->path()) ?? null;

    //     return view('components.layouts.sidebar', compact('menus', 'activeMenu', 'activeSubmenu', 'activeSubSubmenu'));
    // }
}
