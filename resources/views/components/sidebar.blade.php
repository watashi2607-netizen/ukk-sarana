<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
    <img src="{{ asset('sbadmin2/img/Logo-SMK8.png') }}" alt="SMK Logo" style="width: 30px; object-fit:contain">
    <div class="sidebar-brand-text mx-3">PENGADUAN Sarana</div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Data Siswa -->
    <li class="nav-item {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.siswa.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Siswa</span>
        </a>
    </li>

    <!-- Nav Item - Data Kategori -->
    <li class="nav-item {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.kategori.index') }}">
            <i class="fas fa-fw fa-list"></i>
            <span>Data Kategori</span>
        </a>
    </li>

    <!-- Nav Item - Daftar Pengaduan -->
    <li class="nav-item {{ request()->routeIs('admin.pengaduan.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.pengaduan.index') }}">
            <i class="fas fa-fw fa-clipboard-list"></i>
            <span>Daftar Pengaduan</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Nav Item - Logout -->
    <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->