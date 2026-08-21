<div class="logo">
    <h3>SIAKA</h3>
    <small>Sistem Informasi Absensi Karyawan</small>
</div>

<ul>
    <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}">
            <i class="fas fa-home"></i>
            Dashboard
        </a>
    </li>

    <li class="{{ request()->routeIs('karyawan.*') ? 'active' : '' }}">
    <a href="{{ route('karyawan.index') }}">
        <i class="fas fa-users"></i>
        <span>Data Karyawan</span>
    </a>
</li>

<li class="{{ request()->routeIs('jabatan.*') ? 'active' : '' }}">
    <a href="{{ route('jabatan.index') }}">
        <i class="fas fa-building"></i>
        <span>Devisi</span>
    </a>
</li>

<li class="{{ request()->routeIs('admin.biodata.*') ? 'active' : '' }}">
    <a href="{{ route('admin.biodata.index') }}">
        <i class="fas fa-id-card"></i>
        <span>Status Berkas</span>
    </a>
</li>

<li class="{{ request()->routeIs('admin.ktp.*') ? 'active' : '' }}">
    <a href="{{ route('admin.ktp.index') }}">
        <i class="fas fa-address-card"></i>
        <span>Verifikasi KTP</span>
    </a>
</li>

<li class="{{ request()->routeIs('absensi.*') ? 'active' : '' }}">
    <a href="{{ route('absensi.index') }}">
        <i class="fas fa-calendar-check"></i>
        <span>Data Absensi</span>
    </a>
</li>

<li class="{{ request()->routeIs('admin.rekap.*') ? 'active' : '' }}">
    <a href="{{ route('admin.rekap.index') }}">
        <i class="fas fa-chart-column"></i>
        <span>Rekap</span>
    </a>
</li>

<li class="{{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
    <a href="{{ route('admin.laporan.index') }}">
        <i class="fas fa-file-lines"></i>
        <span>Laporan</span>
    </a>
</li>

<li class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
    <a href="{{ route('admin.users.index') }}">
        <i class="fas fa-user-shield"></i>
        <span>Admin</span>
    </a>
</li>

<li class="{{ request()->routeIs('admin.pengaturan') ? 'active' : '' }}">
    <a href="{{ route('admin.pengaturan') }}">
        <i class="fas fa-gear"></i>
        <span>Pengaturan</span>
    </a>
</li>

<li class="mt-auto">
    <form action="{{ route('logout') }}" method="POST">
        @csrf

        <button type="submit" class="logout-btn">
            <i class="fas fa-right-from-bracket"></i>
            <span>Logout</span>
        </button>
    </form>
</li>