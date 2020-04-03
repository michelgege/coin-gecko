<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="currency_page">

<div class="wrap">
    <header>
        <h1>{{$response[0]->name}}</h1>
    </header>
    @include('components\nav')
    <div class="line"></div>

    <img src="{{ $response[0]->image }}" alt="logo-{{ $response[0]->name }}">
    <p class="price">{{ $response[0]->current_price }} €</p>

    <div class="data_container">

        <div class="currency_infos">

            <p class="rank">Market cap rank : {{ $response[0]->market_cap_rank}}</p>
            <p class="supply">Circulating supply: {{ $response[0]->circulating_supply}}</p>


            <p class="high">High / Low 24h: <span class="green">{{ $response[0]->high_24h }} €</span> / <span class="red">{{ $response[0]->low_24h }} €</span></p>

        </div> <!-- div.currency -->

        <div class="chart-container">

            <canvas id="currency_chart"></canvas>
        </div>

    </div> <!-- div.data_container -->


 </div>  <!--wrap -->


    <!-- <script src="https://unpkg.com/chartjs-plugin-crosshair@1.1.4/dist/chartjs-plugin-crosshair.js"></script> -->
    <script src="{{ asset('js/currency.js') }}"></script>
</body>
</html>

