<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SIAKA | Login</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        rel="stylesheet"
    >

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Segoe UI", Arial, sans-serif;
            background: linear-gradient(135deg, #eef4ff, #f8fafc);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 25px;
        }

        .login-wrapper {
            width: 100%;
            max-width: 950px;
            min-height: 560px;
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(15, 23, 42, .15);
            display: flex;
        }

        .login-left {
            width: 45%;
            background: linear-gradient(145deg, #1e3a8a, #2563eb);
            color: white;
            padding: 55px 45px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: "";
            position: absolute;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            background: rgba(255,255,255,.08);
            top: -100px;
            right: -100px;
        }

        .login-left::after {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: rgba(255,255,255,.06);
            bottom: -100px;
            left: -80px;
        }

        .brand-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            background: rgba(255,255,255,.15);
            border: 1px solid rgba(255,255,255,.25);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 35px;
            margin-bottom: 25px;
            position: relative;
            z-index: 2;
        }

        .login-left h1 {
            font-size: 42px;
            font-weight: 800;
            margin-bottom: 10px;
            position: relative;
            z-index: 2;
        }

        .login-left h4 {
            font-size: 20px;
            font-weight: 500;
            margin-bottom: 12px;
            position: relative;
            z-index: 2;
        }

        .login-left p {
            color: rgba(255,255,255,.8);
            line-height: 1.7;
            position: relative;
            z-index: 2;
        }

        .company {
            margin-top: 30px;
            font-weight: 600;
            position: relative;
            z-index: 2;
        }

        .login-right {
            width: 55%;
            padding: 55px 65px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-title {
            margin-bottom: 30px;
        }

        .login-title h2 {
            font-size: 30px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 7px;
        }

        .login-title p {
            color: #64748b;
            margin: 0;
        }

        .form-label {
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }

        .input-group-custom {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            z-index: 5;
        }

        .form-control-custom {
            width: 100%;
            height: 52px;
            border: 1px solid #dbe1ea;
            border-radius: 12px;
            padding: 10px 15px 10px 45px;
            font-size: 15px;
            outline: none;
            transition: .2s;
            background: #fff;
        }

        .form-control-custom:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37,99,235,.10);
        }

        .remember-area {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 18px 0 25px;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #64748b;
            font-size: 14px;
            cursor: pointer;
        }

        .remember-label input {
            width: 17px;
            height: 17px;
            accent-color: #2563eb;
        }

        .forgot-link {
            color: #2563eb;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        .login-button {
            width: 100%;
            height: 52px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            color: white;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: .2s;
            box-shadow: 0 8px 20px rgba(37,99,235,.22);
        }

        .login-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 25px rgba(37,99,235,.30);
        }

        .login-footer {
            text-align: center;
            margin-top: 25px;
            color: #94a3b8;
            font-size: 13px;
        }

        .error-message {
            color: #dc2626;
            font-size: 13px;
            margin-top: 6px;
        }

        .status-message {
            background: #ecfdf5;
            color: #047857;
            border-radius: 10px;
            padding: 10px 13px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .show-password {
            margin-top: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #64748b;
            font-size: 14px;
            cursor: pointer;
        }

        .show-password input {
            width: 17px;
            height: 17px;
            accent-color: #2563eb;
            cursor: pointer;
        }

        @media (max-width: 768px) {

            body {
                padding: 15px;
            }

            .login-wrapper {
                min-height: auto;
                flex-direction: column;
                border-radius: 18px;
            }

            .login-left {
                width: 100%;
                padding: 35px 30px;
                text-align: center;
                align-items: center;
            }

            .login-left h1 {
                font-size: 34px;
            }

            .login-left h4 {
                font-size: 17px;
            }

            .brand-icon {
                width: 65px;
                height: 65px;
                font-size: 28px;
            }

            .company {
                margin-top: 18px;
            }

            .login-right {
                width: 100%;
                padding: 35px 25px;
            }

            .login-title h2 {
                font-size: 26px;
            }

        }

    </style>

</head>

<body>

    <div class="login-wrapper">

        <div class="login-left">

            <div class="brand-icon">
                <i class="fas fa-users"></i>
            </div>

            <h1>SIAKA</h1>

            <h4>
                Sistem Informasi Absensi Karyawan
            </h4>

            <p>
                Sistem informasi untuk membantu
                pengelolaan data dan absensi karyawan
                secara lebih mudah dan terstruktur.
            </p>

            <div class="company">
                CV. Karunia Andalan Sejahtera
            </div>

        </div>


        <div class="login-right">

            <div class="login-title">

                <h2>Selamat Datang</h2>

                <p>
                    Silakan masuk ke akun Anda
                </p>

            </div>


            @if(session('status'))

                <div class="status-message">
                    {{ session('status') }}
                </div>

            @endif


            <form method="POST" action="{{ route('login') }}">

                @csrf


                <div class="mb-3">

                    <label
                        for="username"
                        class="form-label"
                    >
                        Username
                    </label>

                    <div class="input-group-custom">

                        <i class="fas fa-user input-icon"></i>

                        <input
                            id="username"
                            class="form-control-custom"
                            type="text"
                            name="username"
                            value="{{ old('username') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="Masukkan username"
                        >

                    </div>

                    @if($errors->get('username'))

                        <div class="error-message">
                            {{ $errors->first('username') }}
                        </div>

                    @endif

                </div>


                <div class="mb-3">

                    <label
                        for="password"
                        class="form-label"
                    >
                        Password
                    </label>

                    <div class="input-group-custom">

                        <i class="fas fa-lock input-icon"></i>

                        <input
                            id="password"
                            class="form-control-custom"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Masukkan password"
                        >

                    </div>

                    <label
                        for="showPassword"
                        class="show-password"
                    >

                        <input
                            type="checkbox"
                            id="showPassword"
                        >

                        <span>
                            Tampilkan Password
                        </span>

                    </label>

                    @if($errors->get('password'))

                        <div class="error-message">
                            {{ $errors->first('password') }}
                        </div>

                    @endif

                </div>


                <div class="remember-area">

                    <label
                        for="remember_me"
                        class="remember-label"
                    >

                        <input
                            id="remember_me"
                            type="checkbox"
                            name="remember"
                        >

                        <span>
                            Remember me
                        </span>

                    </label>


                    @if (Route::has('password.request'))

                        <a
                            class="forgot-link"
                            href="{{ route('password.request') }}"
                        >
                            Forgot password?
                        </a>

                    @endif

                </div>


                <button
                    type="submit"
                    class="login-button"
                >

                    <i class="fas fa-right-to-bracket me-2"></i>

                    Log in

                </button>

            </form>


            <div class="login-footer">

                © {{ date('Y') }}
                CV. Karunia Andalan Sejahtera

            </div>

        </div>

    </div>


    <script>

        document.getElementById('showPassword').addEventListener('change', function () {

            const password = document.getElementById('password');

            password.type = this.checked ? 'text' : 'password';

        });

    </script>

</body>

</html>