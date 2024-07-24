<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bid Pelatihan | @yield('title')</title>

    {{-- Tabler.IO --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler-flags.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler-payments.min.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler-vendors.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
        rel="stylesheet">


</head>

<style>
    .ps-sm-2 {
        @media screen and (max-width: 576px) {
            padding-left: 4px
        }
    }
</style>

<body>

    <!-- Sidebar -->
    <aside class="navbar navbar-vertical navbar-expand-sm navbar-dark overflow-y-hidden">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
                aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <h1 class="navbar-brand navbar-brand-autodark">
                <a href="{{ route('dashboard') }}">
                    <h1>Bid Pelatihan</h1>
                </a>
                {{-- <h3 class="text-center">Selamat datang {{ Auth::user()->name }}!</h3>
                <h5 class="text-center">Kamu login sebagai {{ Auth::user()->role }}</h5> --}}
            </h1>
            {{-- <div class="navbar-brand navbar-brand-autodark">
                <a href="{{ route('dashboard') }}">
                    <h1>Bid Pelatihan</h1>
                </a>
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                    aria-label="Open user menu" aria-expanded="false">
                    <span class="avatar avatar-sm" style="background-image: url(./static/avatars/000m.jpg)"></span>
                    <div class="d-none d-xl-block ps-2">
                        <div>Paweł Kuna</div>
                        <div class="mt-1 small text-secondary">UI Designer</div>
                    </div>
                </a>
            </div> --}}
            <div class="collapse navbar-collapse" id="sidebar-menu">
                <div class="d-sm-flex pt-sm-2 justify-content-center my-3 ps-sm-2">
                    <a href="#" class="nav-link d-flex lh-1 text-reset p-0">
                        <i
                            class="ti ti-user-filled border border-1 rounded-circle p-1 bg-body-tertiary text-dark-emphasis fs-1"></i>
                        <div class="ps-2">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="mt-1 small text-secondary">{{ ucfirst(Auth::user()->role) }}</div>
                        </div>
                    </a>
                </div>
                <ul class="navbar-nav pt-lg-3">
                    <li class="nav-item {{ Request::route()->named('dashboard') ? 'active' : '' }}">
                        <a class="nav-link" href="/">
                            <div class="d-flex justify-content-center gap-2">
                                <i class="ti ti-layout-dashboard fs-1"></i>
                                <span class="nav-link-title fs-3">
                                    Dashboard
                                </span>
                            </div>
                        </a>
                    </li>

                    @if (Auth::user()->role == 'admin')
                        <li class="nav-item {{ Request::route()->named('pelatihan') ? 'active' : '' }}">
                            <a class="nav-link" href="/pelatihan">
                                <div class="d-flex justify-content-center gap-2">
                                    <i class="ti ti-ad-2 fs-1"></i>
                                    <span class="nav-link-title fs-3">
                                        Pelatihan
                                    </span>
                                </div>
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->role == 'instruktur')
                        <li class="nav-item {{ Request::route()->named('cariPelatihan.view') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('cariPelatihan.view') }}">
                                <div class="d-flex justify-content-center gap-2">
                                    <i class="ti ti-ad-2 fs-1"></i>
                                    <span class="nav-link-title fs-3">
                                        Cari Pelatihan
                                    </span>
                                </div>
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->role == 'admin')
                        <li class="nav-item {{ Request::route()->named('managementUser.view') ? 'active' : '' }}">
                            <a class="nav-link" href="/management-user">
                                <div class="d-flex justify-content-center gap-2">
                                    <i class="ti ti-user-cog fs-1"></i>
                                    <span class="nav-link-title fs-3">
                                        Management User
                                    </span>
                                </div>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}">
                            <div class="d-flex justify-content-center gap-2">
                                <i class="ti ti-logout fs-1"></i> <span class="nav-link-title fs-3">
                                    Logout
                                </span>
                            </div>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="nav-link-title">
                            Management User
                        </span>
                    </a>
                    </li> --}}
                    {{-- <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="nav-link-title">
                            Link 3
                        </span>
                    </a>
                    </li> --}}
                </ul>
            </div>
        </div>
    </aside>

    {{-- sidebar end --}}

    @yield('content')

    {{-- Tabler.IO --}}
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/js/tabler.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
</body>


</html>
