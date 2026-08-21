<x-guest-layout>

    <style>
        body {
            background: linear-gradient(135deg, #eef4ff 0%, #f8fafc 100%);
        }

        .forgot-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 15px;
        }

        .forgot-box {
            width: 100%;
            max-width: 480px;
            background: #ffffff;
            border-radius: 20px;
            padding: 38px;
            box-shadow: 0 15px 40px rgba(30, 58, 138, .12);
            border: 1px solid #e5e7eb;
        }

        .brand {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 18px;
            border-radius: 18px;
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            box-shadow: 0 10px 25px rgba(37, 99, 235, .25);
        }

        .brand h1 {
            margin: 0;
            font-size: 30px;
            font-weight: 800;
            color: #1e3a8a;
        }

        .brand p {
            margin: 5px 0 0;
            color: #64748b;
            font-size: 14px;
        }

        .company {
            margin-top: 8px;
            color: #2563eb !important;
            font-weight: 600;
        }

        .info-text {
            color: #64748b;
            line-height: 1.7;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .input-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #334155;
        }

        .input-box {
            width: 100%;
            border: 1px solid #dbe1ea;
            border-radius: 11px;
            padding: 12px 14px;
            outline: none;
            transition: .2s;
        }

        .input-box:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, .10);
        }

        .button-area {
            display: flex;
            justify-content: flex-end;
            margin-top: 22px;
        }

        .reset-btn {
            border: none;
            border-radius: 11px;
            padding: 12px 20px;
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            color: white;
            font-weight: 700;
            cursor: pointer;
            transition: .2s;
        }

        .reset-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(37, 99, 235, .25);
        }

        .back-login {
            text-align: center;
            margin-top: 22px;
        }

        .back-login a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }

        .back-login a:hover {
            text-decoration: underline;
        }

        .footer {
            text-align: center;
            margin-top: 25px;
            color: #94a3b8;
            font-size: 13px;
        }

        @media (max-width: 576px) {
            .forgot-box {
                padding: 28px 22px;
            }

            .brand h1 {
                font-size: 26px;
            }
        }
    </style>

    <div class="forgot-wrapper">

        <div>

            <div class="forgot-box">

                <div class="brand">

                    <div class="brand-icon">
                        <i class="fas fa-lock"></i>
                    </div>

                    <h1>SIAKA</h1>

                    <p>
                        Sistem Informasi Absensi Karyawan
                    </p>

                    <p class="company">
                        CV. Karunia Andalan Sejahtera
                    </p>

                </div>

                <x-auth-session-status
                    class="mb-4"
                    :status="session('status')"
                />

                <div class="info-text">
                    Lupa password Anda? Tidak masalah.
                    Masukkan alamat email yang terdaftar.
                    Kami akan mengirimkan link untuk membuat
                    password baru.
                </div>

                <form method="POST" action="{{ route('password.email') }}">

                    @csrf

                    <div>

                        <label
                            for="email"
                            class="input-label"
                        >
                            Email
                        </label>

                        <input
                            id="email"
                            class="input-box"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autofocus
                            autocomplete="username"
                        >

                        <x-input-error
                            :messages="$errors->get('email')"
                            class="mt-2"
                        />

                    </div>

                    <div class="button-area">

                        <button
                            type="submit"
                            class="reset-btn"
                        >
                            <i class="fas fa-paper-plane me-2"></i>
                            Kirim Link Reset Password
                        </button>

                    </div>

                </form>

                <div class="back-login">

                    <a href="{{ route('login') }}">
                        <i class="fas fa-arrow-left me-1"></i>
                        Kembali ke Login
                    </a>

                </div>

            </div>

            <div class="footer">
                © {{ date('Y') }} CV. Karunia Andalan Sejahtera
            </div>

        </div>

    </div>

</x-guest-layout>