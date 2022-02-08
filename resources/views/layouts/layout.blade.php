<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- 載入laravel安全性功能 -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- 載入sweetalert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- 載入bs5  -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script> -->
    <!-- 載入tailwindcss -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- 載入jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>科技大學校園資訊系統</title>
</head>

<body>
    <div class="container max-w-5xl mx-auto overflow-auto">
        <div class="header w-full max-h-24">
        <a href="/" title="{{ $title->text }}">
            <img class="w-full h-full" src="{{ asset('storage/'.$title->img) }}" alt="{{ $title->text }}" class="w-full">
        </a>
        </div>
        <div class="main w-full grid grid-cols-12">
            @yield("main")
        </div>
        <div class="footer w-full bg-yellow-300">
            <div class="footer-text text-center">{{ $bottom }}</div>
        </div>
    </div>
    <div id="modal"></div>
</body>

</html>
@yield("script")