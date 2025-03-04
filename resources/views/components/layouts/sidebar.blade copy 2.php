@php
    use App\Models\Menu;
    use Illuminate\Support\Facades\Route;

    $activeMenuName = session('activeMenu');
    $activeSubmenuName = session('activeSubmenu');
    $activeSubSubmenuName = session('activeSubSubmenu');

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
                    @endphp
                    <li
                        class="nav-section {{ $menu->submenus->contains(fn($submenu) => isActiveMenu($submenu, $activeMenuName, $activeSubmenuName, $activeSubSubmenuName)) ? 'active' : '' }}">
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
                                            $url = '#'; // Default jika tidak ada route valid

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
                                                    // Jika category_id = 0, arahkan ke route yang sesuai dari database TANPA query parameter
                                                    $url = route($subsubmenu->route);
                                                } else {
                                                    // Jika tidak ada category_id, tetap gunakan route biasa TANPA query parameter
                                                    $url = route($subsubmenu->route);
                                                }
                                            }
                                        @endphp

                                        <li
                                            class="{{ isActiveMenu($subsubmenu, $activeMenuName, $activeSubmenuName, $activeSubSubmenuName) ? 'active open' : '' }}">

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
        document.querySelectorAll(".nav-item a, .sub-menu-item").forEach(item => {
            item.addEventListener("click", function(e) {
                let menu = this.dataset.menu || null;
                let submenu = this.dataset.submenu || null;
                let subsubmenu = this.dataset.subsubmenu || null;

                if (menu || submenu || subsubmenu) {
                    fetch("{{ route('updateActiveMenu') }}", {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({
                                menu,
                                submenu,
                                subsubmenu
                            })
                        }).then(response => response.json())
                        .then(data => {
                            if (data.status === "success") {
                                // Ambil URL tujuan dari href elemen yang diklik
                                let targetUrl = item.getAttribute("href");

                                // Redirect ke halaman baru, bukan hanya reload
                                window.location.href = targetUrl;
                            }
                        });
                }
            });
        });
    });
</script>
