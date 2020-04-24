<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="currency_page">

<div class="wrap">
    <header>
        <h1 data-id="{{$response[0]->id}}"> {{$response[0]->name}} </h1>
    </header>
    @include('components\nav')
    <div class="line"></div>


    <div class="data_container">

        <div class="currency">
            <img src="{{ $response[0]->image }}" alt="logo-{{ $response[0]->name }}">

            @if( $response[0]-> price_change_percentage_24h > 0)
                <p class="price"><span class="red">{{ $response[0]->current_price }} EUR </span></p>
            @elseif($response[0]-> price_change_percentage_24h < 0)
                <p class="price"><span class="green">{{ $response[0]->current_price }} EUR </span></p>
            @else
                <p class="price">{{ $response[0]->current_price }} EUR </p>
            @endif
        </div>

        <div class="currency_infos">
            <p class="rank">Market cap rank : {{ $response[0]->market_cap_rank}}</p>
            <p class="supply">Circulating supply: {{ $response[0]->circulating_supply}}</p>
            <p class="high">High / Low 24h: <span class="green">{{ $response[0]->high_24h }} €</span> / <span class="red">{{ $response[0]->low_24h }} €</span></p>
        </div> <!-- div.currency_infos -->


    </div> <!-- div.data_container -->


    <div class="time_buttons">
        <div data-time="1"><p>24h</p></div>
        <div data-time="7"><p>7d</p></div>
        <div data-time="14"><p>14d</p></div>
        <div data-time="30"><p>30d</p></div>
        <div data-time="90"><p>90d</p></div>
    </div>

    <figure class="highcharts-figure">
        <p>Loading...</p>
        <div id="container"></div>
    </figure>

 </div>  <!--wrap -->



    <script src="{{ asset('js/currency.js') }}"></script>

</body>
</html>

