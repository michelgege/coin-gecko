<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Home</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="home_page">

    <header>
        <h1>Market cap</h1>
    </header>


    <div class="wrap">
        @include('components/nav')

        <div class="line"></div>

        <div class="currencies_container">

        @include('partials/currencies')

        </div> <!-- currencies_container -->
        <div class="more_button">
            <p class="more">See more</p>
            <p class="loading">Loading...</p>
        </div>
     </div><!-- wrap -->
    <div class="arrow_container">
        <img class="arrow" src="/images/arrow-white.svg" alt="">
    </div>

<script src="{{ asset('js/index.js') }}"></script>
<script src="{{ asset('js/common.js') }}"></script>
</body>
</html>
