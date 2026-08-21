<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SIAKA | @yield('title')</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <link
        rel="stylesheet"
        href="{{ asset('assets/css/style.css') }}"
    >

    @stack('styles')

</head>

<body>

<div class="wrapper">

    <div class="sidebar" id="sidebar">

        @include('layouts.sidebar-karyawan')

    </div>

    <div class="main">

        <div class="topbar">

            <div class="topbar-left">

                <button
                    type="button"
                    class="menu-toggle"
                    id="menuToggle"
                >
                    <i class="fas fa-bars"></i>
                </button>

                <h4 class="mb-0">
                    @yield('title')
                </h4>

            </div>


            {{-- BAGIAN KANAN TOPBAR --}}
            <div class="d-flex align-items-center">


                {{-- NOTIFIKASI --}}
                <div class="dropdown me-3">

                    <button
                        type="button"
                        class="btn position-relative"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                        title="Notifikasi"
                    >

                        <i
                            class="fas fa-bell"
                            style="font-size: 20px;"
                        ></i>

                    </button>


                    <ul class="dropdown-menu dropdown-menu-end shadow">

                        <li>

                            <h6 class="dropdown-header">
                                Notifikasi
                            </h6>

                        </li>


                        <li>

                            <span class="dropdown-item-text text-muted">

                                <i
                                    class="fas fa-check-circle text-success me-2"
                                ></i>

                                Belum ada notifikasi.

                            </span>

                        </li>

                    </ul>

                </div>


                {{-- PROFILE --}}
                <div class="profile">

                    <img
                        src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=2563EB&color=fff"
                        alt="User"
                    >

                    <div>

                        <strong>
                            {{ auth()->user()->name }}
                        </strong>

                        <br>

                        <small>

                            @if(auth()->user()->role === 'admin_lapangan')

                                Admin Lapangan

                            @else

                                Karyawan

                            @endif

                        </small>

                    </div>

                </div>


            </div>

        </div>


        <div class="container-fluid p-4">

            @yield('content')

        </div>

    </div>

</div>


<div
    class="sidebar-overlay"
    id="sidebarOverlay"
></div>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const menuToggle =
        document.getElementById('menuToggle');

    const sidebar =
        document.getElementById('sidebar');

    const sidebarOverlay =
        document.getElementById('sidebarOverlay');


    if (menuToggle) {

        menuToggle.addEventListener('click', function () {

            sidebar.classList.toggle('show');

            sidebarOverlay.classList.toggle('show');

        });

    }


    if (sidebarOverlay) {

        sidebarOverlay.addEventListener('click', function () {

            sidebar.classList.remove('show');

            sidebarOverlay.classList.remove('show');

        });

    }

});

</script>


@stack('scripts')

</body>

</html>