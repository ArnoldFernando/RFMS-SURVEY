<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>RFMS</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loader {
            width: 300px;
            height: 300px;
            background: #fff;
            position: relative;
            box-sizing: border-box;
            border: 1px solid #e0e0e0;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        }

        .loader::after {
            content: '';
            width: calc(100% - 40px);
            height: calc(100% - 40px);
            position: absolute;
            top: 20px;
            left: 20px;
            background-image:
                linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.6) 50%, transparent 100%),
                linear-gradient(#ddd 120px, transparent 0),
                linear-gradient(#ddd 20px, transparent 0),
                linear-gradient(#ddd 60px, transparent 0);
            background-repeat: no-repeat;
            background-size: 100px 200px, 100% 120px, 100% 20px, 100% 40px;
            background-position: -300px 0, center 0, center 150px, center 200px;
            animation: animloader 1.2s linear infinite;
            box-sizing: border-box;
        }

        @keyframes animloader {
            to {
                background-position: 300px 0, center 0, center 150px, center 200px;
            }
        }
    </style>

    <!-- Extra CSS (from views) -->
    @yield('css')

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div id="app">
        <div class="preloader">
            <span class="loader"></span>
        </div>

        @extends('adminlte::page')

        @section('content')
            <main class="py-4">
                {{ $slot }}
            </main>
        @stop
    </div>

    <script>
        window.addEventListener('load', () => {
            document.querySelector('.preloader').style.display = 'none';
        });
    </script>

    @yield('js')

    @stack('scripts')

</body>

</html>
