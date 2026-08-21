@php
    use App\Models\Ktp;

    $pendingKtpCount = Ktp::where('status', 'Menunggu')->count();
@endphp

<div>
    <h4>@yield('title')</h4>
</div>

<div class="admin-info d-flex align-items-center gap-3">

    {{-- NOTIFIKASI --}}
    <div class="dropdown">

        <button
            class="btn position-relative"
            type="button"
            data-bs-toggle="dropdown"
            aria-expanded="false"
            style="font-size: 22px;"
        >
            <i class="fas fa-bell"></i>

            @if($pendingKtpCount > 0)
                <span
                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                    style="font-size: 10px;"
                >
                    {{ $pendingKtpCount }}
                </span>
            @endif

        </button>

        <ul class="dropdown-menu dropdown-menu-end shadow">

            <li>
                <h6 class="dropdown-header">
                    Notifikasi
                </h6>
            </li>

            @if($pendingKtpCount > 0)

                <li>
                    <a
                        class="dropdown-item"
                        href="{{ route('admin.ktp.index') }}"
                    >
                        <i class="fas fa-id-card text-warning me-2"></i>

                        <strong>
                            {{ $pendingKtpCount }} KTP
                        </strong>

                        menunggu verifikasi
                    </a>
                </li>

            @else

                <li>
                    <span class="dropdown-item-text text-muted">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        Tidak ada KTP yang perlu diverifikasi.
                    </span>
                </li>

            @endif

        </ul>

    </div>


    {{-- INFORMASI ADMIN --}}
    <img
        src="https://ui-avatars.com/api/?name=Admin&background=2563EB&color=fff"
        alt="Admin"
    >

    <div>
        <strong>Administrator</strong>
        <br>
        <small>tester</small>
    </div>

</div>


{{-- Bootstrap JS untuk dropdown notifikasi --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>