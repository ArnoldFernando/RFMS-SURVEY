<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Bebas Neue', sans-serif;
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
            opacity: 0.9;

        }

        h1 {
            font-family: 'Bebas Neue', sans-serif;
            color: #fff;
            text-align: center;
            font-size: 70px;
            text-align: start;
            font-weight: 900;
            letter-spacing: .2ch
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center text-light">
            <div class="row p-5">
                <div class="col-6">
                    <h1>RECORDS FILES <br> MANAGEMENT <br>SYSTEM</h1>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quisquam debitis nostrum inventore ea
                        dolores ipsa. Nobis est deleniti itaque harum?</p>

                    <a style="font-family: 'Gill Sans Ultra Bold', sans-serif;" class="btn btn-light p-3 text-success "
                        href="login">GET
                        STARTED</a>
                </div>


                <div class="col-6">
                    <div class="text-center mb-3">
                        <img src="{{ asset('asset/logo.png') }}" alt="Logo" class="img-fluid" style="width: 350px;">
                    </div>

                </div>
            </div>
        </div>
</body>

</html>
