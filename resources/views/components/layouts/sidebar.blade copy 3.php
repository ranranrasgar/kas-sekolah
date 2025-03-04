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
        if (in_array($menu->name, [$activeMenuName, $activeSubmenuName, $activeSubSubmenuName])) {
            return true;
        }

        // Jika menu memiliki submenu, periksa apakah ada submenu atau subsubmenu yang aktif
        if ($menu->submenus) {
            foreach ($menu->submenus as $submenu) {
                if (in_array($submenu->name, [$activeSubmenuName, $activeSubSubmenuName])) {
                    return true;
                }

                if ($submenu->subsubmenus) {
                    foreach ($submenu->subsubmenus as $subsubmenu) {
                        if ($subsubmenu->name == $activeSubSubmenuName) {
                            return true;
                        }
                    }
                }
            }
        }

        return false;
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
                    <div class="collapse" id="dashboard">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="1">
                                    <span class="sub-item">Dashboard 1</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                @foreach ($menus as $menu)
                    @php
                        $menuActive = isActiveMenu($menu, $activeMenuName, $activeSubmenuName, $activeSubSubmenuName);
                    @endphp
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="{{ $menu->icon }}"></i>
                            <p>{{ $menu->name }}</p>
                        </span>
                        <h4 class="text-section">{{ $menu->name }}</h4>
                    </li>

                    @if ($menu->submenus->isNotEmpty())
                        @foreach ($menu->submenus as $submenu)
                            @php $submenuActive = isActiveMenu($submenu, $activeMenuName, $activeSubmenuName, $activeSubSubmenuName); @endphp
                            {{-- <li class="nav-item {{ $submenuActive ? 'active' : '' }}">
                                <a href="#" class="menu-item" data-menu="{{ $menu->name ?? '' }}"
                                    data-submenu="{{ $submenu->name ?? '' }}"> --}}
                            <li class="nav-item active submenu">
                                <a data-bs-toggle="collapse" href="#{{ $submenu->name ?? '' }}">
                                    <i class="{{ $submenu->icon }}"></i>
                                    <p>{{ $submenu->name }}</p>
                                    <span class="caret"></span>
                                </a>

                                <ul class="nav nav-collapse {{ $submenuActive ? 'show' : 'collapse' }}">
                                    @foreach ($submenu->subsubmenus as $subsubmenu)
                                        @php
                                            $url =
                                                $subsubmenu->route !== '#' && Route::has($subsubmenu->route)
                                                    ? route(
                                                        $subsubmenu->route,
                                                        $subsubmenu->category_id && $subsubmenu->category_id !== '0'
                                                            ? ['category_id' => $subsubmenu->category_id]
                                                            : [],
                                                    )
                                                    : '#';

                                        @endphp

                                        <li
                                            class="{{ isActiveMenu($subsubmenu, $activeMenuName, $activeSubmenuName, $activeSubSubmenuName) ? 'active open' : '' }}">

                                            <a href="{{ $url }}" class="sub-menu-item"
                                                data-menu="{{ $menu->name ?? '' }}"
                                                data-submenu="{{ $submenu->name ?? '' }}"
                                                data-subsubmenu="{{ $subsubmenu->name ?? '' }}">

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
