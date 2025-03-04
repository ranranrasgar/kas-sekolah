@php
    use App\Models\Menu;
    use Illuminate\Support\Facades\Route;

    $activeMenuName = session('activeMenu');
    $activeSubmenuName = session('activeSubmenu');
    $activeSubSubmenuName = session('activeSubSubmenu');

    // dd($activeMenuName, $activeSubmenuName, $activeSubSubmenuName);

    $menus = Menu::whereNull('parent_id')->with('submenus.subsubmenus')->get();
    $currentRoute = Route::currentRouteName();

    function isActiveMenu($menu, $activeMenuName, $activeSubmenuName, $activeSubSubmenuName)
    {
        return in_array($menu->name, [$activeMenuName, $activeSubmenuName, $activeSubSubmenuName]);
    }
@endphp

<div class="sidebar" data-background-color="dark">
    <x-components.layouts.logo />
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item">
                    <a href="/">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                        <span class="badge badge-secondary">1</span>
                    </a>
                </li>

                @foreach ($menus as $menu)
                    @php
                        $menuActive = isActiveMenu($menu, $activeMenuName, $activeSubmenuName, $activeSubSubmenuName);
                        $hasActiveSubmenu = $menu->submenus->contains(
                            fn($submenu) => isActiveMenu(
                                $submenu,
                                $activeMenuName,
                                $activeSubmenuName,
                                $activeSubSubmenuName,
                            ),
                        );
                    @endphp
                    <li class="nav-section {{ $menuActive || $hasActiveSubmenu ? 'active' : '' }}">
                        <span class="sidebar-mini-icon">
                            <i class="{{ $menu->icon }}"></i>
                            <p>{{ $menu->name }}</p>
                        </span>
                        <h4 class="text-section">{{ $menu->name }}</h4>
                    </li>

                    @if ($menu->submenus->isNotEmpty())
                        @foreach ($menu->submenus as $submenu)
                            @php $submenuActive = isActiveMenu($submenu, $activeMenuName, $activeSubmenuName, $activeSubSubmenuName); @endphp
                            <li class="nav-item {{ $submenuActive ? 'active' : '' }}">
                                <a href="#" class="menu-item" data-menu="{{ $menu->name }}"
                                    data-submenu="{{ $submenu->name }}">
                                    <i class="{{ $submenu->icon }}"></i>
                                    <p>{{ $submenu->name }}</p>
                                    <span class="caret"></span>
                                </a>
                                <ul class="nav nav-collapse {{ $submenuActive ? 'show' : 'collapse' }}">
                                    @foreach ($submenu->subsubmenus as $subsubmenu)
                                        @php
                                            // Default jika tidak ada route valid
                                            $url = '#';

                                            if ($subsubmenu->route !== '#' && Route::has($subsubmenu->route)) {
                                                if (
                                                    !is_null($subsubmenu->category_id) &&
                                                    $subsubmenu->category_id !== '#' &&
                                                    $subsubmenu->category_id !== '0'
                                                ) {
                                                    // Jika category_id valid dan bukan '0', tambahkan sebagai query parameter
                                                    $url = route($subsubmenu->route, [
                                                        'category_id' => $subsubmenu->category_id,
                                                    ]);
                                                } elseif ($subsubmenu->category_id === '0') {
                                                    // Jika category_id = 0, arahkan ke route tanpa query parameter
                                                    $url = route($subsubmenu->route);
                                                } else {
                                                    // Jika tidak ada category_id, gunakan route biasa tanpa query parameter
                                                    $url = route($subsubmenu->route);
                                                }
                                            }
                                        @endphp
                                        <li
                                            class="{{ isActiveMenu($subsubmenu, $activeMenuName, $activeSubmenuName, $activeSubSubmenuName) ? 'active' : '' }}">
                                            <a href="{{ $url }}" class="sub-menu-item"
                                                data-menu="{{ $menu->name }}" data-submenu="{{ $submenu->name }}"
                                                data-subsubmenu="{{ $subsubmenu->name }}">
                                                <i class="{{ $subsubmenu->icon }}"></i>
                                                <span class="sub-item">{{ $subsubmenu->name }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    @endif
                @endforeach


            </ul>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".sub-menu-item").forEach(item => {
            item.addEventListener("click", function(e) {
                let menu = this.dataset.menu;
                let submenu = this.dataset.submenu;
                let subsubmenu = this.dataset.subsubmenu;

                fetch("{{ route('updateActiveMenu') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        menu,
                        submenu,
                        subsubmenu
                    })
                });
            });
        });
    });
</script>
