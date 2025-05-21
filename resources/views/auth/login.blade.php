<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('penro.ico') }}">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-image: url('{{ asset('asset/bg.jpg') }}');

            /* Replace with your own URL or asset */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;

        }

        .card {
            background-color: #26590E;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        form {
            padding: 0 1em 0;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card pt-4 text-light"
                    style="backdrop-filter: blur(12px) saturate(120%); background-color: rgba(38, 89, 14, 0.55); border: 1px solid rgba(255,255,255,0.18); box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);">
                    <div class="text-center mb- px-4">
                        <img src="{{ asset('asset/logo.png  ') }}" alt="Logo" class="img-fluid"
                            style="width: 70px;">
                        <div class="text-center fs-4">{{ __('WELCOME TO PENRO') }}</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}" class="">
                                @csrf

                                <div class="mb-3 row">
                                    <div class="">
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email" autofocus
                                            placeholder="Email">

                                        @error('email')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <div class="">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="current-password" placeholder="Password">

                                        @error('password')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    @if (Route::has('password.request'))
                                        <a class="mt-1 text-white text-end" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>


                                <div class="row mb-0">
                                    <div class="">
                                        <button type="submit" class="btn btn-primary w-100">
                                            {{ __('Login') }}
                                        </button>
                                    </div>
                                </div>

                                <div class="m-3">
                                    <p>dont have account? <a href="{{ route('register') }}"
                                            class="text-danger">Register
                                            here</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>
