<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SIAKA | @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ secure_asset('assets/css/style.css') }}">
</head>

<body>

<div class="sidebar" id="adminSidebar">
    @include('layouts.sidebar')
</div>

<div class="sidebar-overlay" id="adminSidebarOverlay"></div>

<div class="main">

    <div class="topbar">

        <button
            type="button"
            class="admin-menu-toggle"
            id="adminMenuToggle"
        >
            <i class="fas fa-bars"></i>
        </button>

        @include('layouts.navbar')

    </div>

    <div class="container-fluid p-4">
        @yield('content')
    </div>

</div>

<script>
    const adminMenuToggle = document.getElementById('adminMenuToggle');
    const adminSidebar = document.getElementById('adminSidebar');
    const adminSidebarOverlay = document.getElementById('adminSidebarOverlay');

    adminMenuToggle.addEventListener('click', function () {
        adminSidebar.classList.toggle('show');
        adminSidebarOverlay.classList.toggle('show');
    });

    adminSidebarOverlay.addEventListener('click', function () {
        adminSidebar.classList.remove('show');
        adminSidebarOverlay.classList.remove('show');
    });

    document.querySelectorAll('#adminSidebar a').forEach(function (link) {
        link.addEventListener('click', function () {
            if (window.innerWidth <= 768) {
                adminSidebar.classList.remove('show');
                adminSidebarOverlay.classList.remove('show');
            }
        });
    });
</script>

@stack('scripts')

</body>
</html>