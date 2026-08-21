<div class="logo">
    <h3>SIAKA</h3>
    <small>Sistem Informasi Absensi Karyawan</small>
</div>

<ul>

    <li class="{{ request()->routeIs('karyawan.dashboard') ? 'active' : '' }}">
        <a href="{{ route('karyawan.dashboard') }}">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="{{ request()->routeIs('karyawan.absensi.masuk') ? 'active' : '' }}">
        <a href="{{ route('karyawan.absensi.masuk') }}">
            <i class="fas fa-right-to-bracket"></i>
            <span>Absen Masuk</span>
        </a>
    </li>

    <li class="{{ request()->routeIs('karyawan.absensi.pulang') ? 'active' : '' }}">
        <a href="{{ route('karyawan.absensi.pulang') }}">
            <i class="fas fa-right-from-bracket"></i>
            <span>Absen Pulang</span>
        </a>
    </li>

    <li class="{{ request()->routeIs('karyawan.biodata.*') ? 'active' : '' }}">
        <a href="{{ route('karyawan.biodata.edit') }}">
            <i class="fas fa-id-card"></i>
            <span>Biodata</span>
        </a>
    </li>

    <li class="{{ request()->routeIs('karyawan.profile*') ? 'active' : '' }}">
        <a href="{{ route('karyawan.profile') }}">
            <i class="fas fa-user"></i>
            <span>Profil</span>
        </a>
    </li>

    @if(auth()->user()->role === 'admin_lapangan')

        <li class="{{ request()->routeIs('karyawan.laporan-pekerjaan.*') ? 'active' : '' }}">
            <a href="{{ route('karyawan.laporan-pekerjaan.index') }}">
                <i class="fas fa-file-lines"></i>
                <span>Laporan Pekerjaan</span>
            </a>
        </li>

        <li class="{{ request()->routeIs('karyawan.laporan-pengeluaran.*') ? 'active' : '' }}">
            <a href="{{ route('karyawan.laporan-pengeluaran.index') }}">
                <i class="fas fa-money-bill-wave"></i>
                <span>Laporan Pengeluaran</span>
            </a>
        </li>

    @endif

    <li class="mt-auto">
        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit" class="logout-btn">
                <i class="fas fa-right-from-bracket"></i>
                <span>Logout</span>
            </button>
        </form>
    </li>

</ul>