<div class="page-header">
    {{-- <h4 class="page-title">
        {{ $activeSubSubmenu ?? ($activeSubmenu ?? ($activeMenu ?? 'Dashboard')) }}
    </h4> --}}
    <ul class="breadcrumbs">
        <li class="nav-home">
            <a href="{{ url('/') }}">
                <i class="fas fa-home"></i>
            </a>
        </li>

        @if (!empty($activeMenu))
            <li class="separator"><i class="fa fa-angle-right"></i></li>
            <li class="nav-item">
                <a href="#">
                    {{-- <i class="fas fa-folder"></i> --}}
                    {{ $activeMenu }}
                </a>
            </li>
        @endif

        @if (!empty($activeSubmenu))
            <li class="separator"><i class="fa fa-angle-right"></i></li>
            <li class="nav-item">
                <a href="#">
                    {{-- <i class="fas fa-folder"></i> --}}
                    {{ $activeSubmenu }}
                </a>
            </li>
        @endif

        @if (!empty($activeSubSubmenu))
            <li class="separator"><i class="fa fa-angle-right"></i></li>
            <li class="nav-item">
                <a href="javascript:history.back();">
                    {{-- <i class="fas fa-folder"></i> --}}
                    {{ $activeSubSubmenu }}
                </a>
            </li>
        @endif
    </ul>
</div>
