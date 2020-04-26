<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Portfolio</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>


<body class="portfolio_page">
<div class="wrap">

    <header>
        <h1>My portfolio</h1>
    </header>

    @include('components/nav')
    <div class="line"></div>

    <div class="arrow_container">
        <img class="arrow" src="/images/arrow-white.svg" alt="">
    </div>

    <div class="filters_container">
        <div data-filter="all" class="filter active">All</div>
        <div data-filter="owned" class="filter">Owned</div>
        <div data-filter="others" class="filter">Others</div>
    </div>


    <p class="total_amount">Your portfolio worth <span></span> {{ Config::get('vars.currency') }}</p>


    <div class="currencies_container">
        @include('partials/portfolio_currencies')
    </div> <!--div.currencies_container-->

    <div class="more_button">
        <p class="more">See more</p>
        <p class="loading">Loading...</p>
    </div>

</div> <!--div.wrap-->

<script src="{{ asset('js/portfolio.js') }}"></script>
<script src="{{ asset('js/common.js') }}"></script>

</body>
</html>
