<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Breadcrumb extends Component
{
    public function render(): View|Closure|string
    {
        // dd(session()->all());
        return view('components.breadcrumb', [
            'activeMenu' => session('activeMenu', ''),
            'activeSubmenu' => session('activeSubmenu', ''),
            'activeSubSubmenu' => session('activeSubSubmenu', '')
        ]);
    }
}
