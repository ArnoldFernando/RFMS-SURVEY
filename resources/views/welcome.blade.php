<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

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
        }

        h1 {
            font-family: 'Bebas Neue', sans-serif;
            color: #fff;
            font-size: 100px;
            font-weight: 900;
        }

        .glass {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            border: 1px solid rgba(255, 255, 255, 0.18);
            padding: 3rem 2rem;
        }

        .small-logo {
            display: none;
        }

        .btn-start {
            font-family: 'Gill Sans Ultra Bold', sans-serif;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            h1 {
                font-size: 3rem;
                text-align: center;
            }

            .btn-start {
                display: block;
                margin: 0 auto;
            }

            .glass {
                border-radius: 0;
                padding: 2rem 1rem;
            }

            .logo {
                display: none;
            }

            .small-logo {
                display: block;
                text-align: center;
                margin-bottom: 1rem;
            }

            .small-logo img {
                max-width: 120px;
            }
        }
    </style>
</head>

<body>
    <div class="container glass text-light">
        <div class="row align-items-center">
            <!-- Text Content -->
            <div class="col-12 col-lg-6 mb-4 mb-lg-0 ps-lg-5">
                <h1 class="text-lg-start text-center">
                    RECORDS FILES <br> MANAGEMENT <br> SYSTEM
                </h1>
                <div class="small-logo">
                    <img src="{{ asset('asset/logo.png') }}" alt="Logo" class="img-fluid">
                </div>
                <p class="text-lg-start text-center">
                    This system is designed to organize and manage various records in the Survey and Mapping Section.
                </p>
                <div class="text-lg-start text-center">
                    <a class="btn btn-light text-success btn-start px-4 py-2" href="login">GET STARTED</a>
                </div>
            </div>

            <!-- Logo for large screens -->
            <div class="col-12 col-lg-6 text-center logo">
                <img src="{{ asset('asset/logo.png') }}" alt="Logo" class="img-fluid" style="max-width: 350px;">
            </div>
        </div>
    </div>

    <!-- Optional Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
