<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class EnsureUserIsAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            if ($request->route() && $request->route()->getName() !== 'login') {
                return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
            }
        } else {
            $currentRoute = $request->route() ? $request->route()->getName() : null;
            if ($currentRoute) {
                // Ambil menu yang sesuai dari database
                $activeMenu = Menu::where('route', $currentRoute)->first();
                $activeSubmenu = $activeMenu ? $activeMenu->parent : null;
                $activeSubSubmenu = $activeSubmenu ? $activeSubmenu->parent : null;

                session([
                    'activeMenu' => $activeMenu ? $activeMenu->id : null,
                    'activeSubmenu' => $activeSubmenu ? $activeSubmenu->id : null,
                    'activeSubSubmenu' => $activeSubSubmenu ? $activeSubSubmenu->id : null,
                ]);
            }
        }
        return $next($request);
    }
}
