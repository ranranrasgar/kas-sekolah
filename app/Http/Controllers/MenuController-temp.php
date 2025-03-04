<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    // public function setActiveMenu(Request $request)
    // {
    //     if (
    //         session('activeMenu') !== $request->menu ||
    //         session('activeSubmenu') !== $request->submenu ||
    //         session('activeSubSubmenu') !== $request->subsubmenu
    //     ) {
    //         session([
    //             'activeMenu' => $request->menu,
    //             'activeSubmenu' => $request->submenu,
    //             'activeSubSubmenu' => $request->subsubmenu,
    //         ]);
    //         session()->save();
    //     }

    //     return response()->json(['status' => 'success']);
    // }


    // public function setActiveMenu(Request $request)
    // {
    //     session([
    //         'activeMenu' => $request->menu,
    //         'activeSubmenu' => $request->submenu,
    //         'activeSubSubmenu' => $request->subsubmenu,
    //     ]);
    //     session()->save();
    //     // dd(session()->all());
    //     return response()->json(['status' => 'success']);
    // }

    // public function getSidebarMenu()
    // {
    //     $roleId = Auth::user()->role_id; // Sesuaikan dengan struktur role Anda

    //     // Ambil semua menu utama
    //     $menus = Menu::whereNull('parent_id')
    //         ->whereIn('id', function ($query) use ($roleId) {
    //             $query->select('menu_id')
    //                 ->from('role_menu')
    //                 ->where('role_id', $roleId);
    //         })
    //         ->orderBy('ordering')
    //         ->with(['submenus' => function ($query) use ($roleId) {
    //             $query->whereIn('id', function ($subQuery) use ($roleId) {
    //                 $subQuery->select('menu_id')
    //                     ->from('role_menu')
    //                     ->where('role_id', $roleId);
    //             })->with('submenus')->orderBy('ordering');
    //         }])
    //         ->get();

    //     return view('layouts.sidebar', compact('menus'));
    // }
}
