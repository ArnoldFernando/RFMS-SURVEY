<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('penro.ico') }}">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-image: url('{{ asset('asset/bg.jpg') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            color: #fff;
            /* Make all text light by default */
        }

        .card {
            background-color: #26590E;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        .form-control {
            font-family: 'Roboto', sans-serif;
            color: #fff;
            /* Make input text light */
        }

        .form-control::placeholder {
            color: #fff;
            opacity: 0.8;
        }

        .card-header-title {
            font-size: 1.8rem;
            color: #fff;
            text-align: center;
        }

        .btn-custom:hover {
            background-color: #eaeaea;
        }

        /* Register button: dark text */
        .btn-register {
            background: rgba(255, 255, 255, 0.25);
            color: #26590E !important;
            border: none;
            font-weight: bold;
            backdrop-filter: blur(2px);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4 text-light"
                    style="background: rgba(38, 89, 14, 0.6); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);">
                    <div class="text-center mb-3">
                        <img src="{{ asset('asset/logo.png') }}" alt="Logo" class="img-fluid" style="width: 70px;">
                        <div class="card-header-title">REGISTER TO SURVEY RFMS</div>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}" class="text-light">
                            @csrf

                            <div class="mb-3">
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" required autocomplete="name" autofocus
                                    placeholder="Full Name"
                                    style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.2); backdrop-filter: blur(2px); color: #fff; color: #fff;">
                                @error('name')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email"
                                    placeholder="Email Address"
                                    style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.2); backdrop-filter: blur(2px); color: #fff;">
                                @error('email')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3 position-relative">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="new-password" placeholder="Password"
                                    style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.2); backdrop-filter: blur(2px); color: #fff;"
                                    oninput="toggleShowBtn('password', 'password-toggle-btn')">
                                <button type="button" id="password-toggle-btn"
                                    class="btn btn-sm position-absolute top-50 end-0 translate-middle-y me-2 d-none"
                                    style="z-index:2; background: transparent !important;"
                                    onclick="togglePassword('password', this)">
                                    <span class="password-icon"><i class="bi bi-eye"></i></span>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3 position-relative">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password"
                                    placeholder="Confirm Password"
                                    style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.2); backdrop-filter: blur(2px); color: #fff;"
                                    oninput="toggleShowBtn('password-confirm', 'password-confirm-toggle-btn')">
                                <button type="button" id="password-confirm-toggle-btn"
                                    class="btn btn-sm position-absolute top-50 end-0 translate-middle-y me-2 d-none"
                                    style="z-index:2; background: transparent !important;"
                                    onclick="togglePassword('password-confirm', this)">
                                    <span class="password-icon"><i class="bi bi-eye"></i></span>
                                </button>
                            </div>

                            <!-- Bootstrap Icons CDN -->
                            <link rel="stylesheet"
                                href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

                            <script>
                                function togglePassword(inputId, btn) {
                                    const input = document.getElementById(inputId);
                                    const icon = btn.querySelector('.password-icon i');
                                    if (input.type === "password") {
                                        input.type = "text";
                                        icon.classList.remove('bi-eye');
                                        icon.classList.add('bi-eye-slash');
                                    } else {
                                        input.type = "password";
                                        icon.classList.remove('bi-eye-slash');
                                        icon.classList.add('bi-eye');
                                    }
                                }

                                function toggleShowBtn(inputId, btnId) {
                                    const input = document.getElementById(inputId);
                                    const btn = document.getElementById(btnId);
                                    if (input.value.length > 0) {
                                        btn.classList.remove('d-none');
                                    } else {
                                        btn.classList.add('d-none');
                                    }
                                }
                            </script>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-register">
                                    {{ __('Register') }}
                                </button>
                            </div>

                            <div class="text-center">
                                <p class="m-0">Already have an account?
                                    <a href="{{ route('login') }}" class="text-decoration-underline text-white">Login
                                        here</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
