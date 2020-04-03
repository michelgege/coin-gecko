<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="home_page">

    <header>
        <h1>Market cap</h1>
    </header>


    <div class="wrap">
        @include('components\nav')

        <div class="line"></div>

        <div class="currencies_container">

            @foreach($response as $currency)

                <a href="/currency/{{ $currency -> id }}">
                    <div class="currency_container" data-id="{{ $currency -> id }}" data-aos="fade-up">


                        <img src="{{ $currency -> image }}" alt="logo {{ $currency -> id }}">

                        <p class="currency_name">{{ $currency -> name }}</p>

                        <p class="currency_price">
                            @if($currency -> price_change_percentage_24h > 0)
                                <span class="green">
                                    {{ $currency -> current_price }} EUR
                                </span>
                            @elseif ($currency -> price_change_percentage_24h < 0)
                                <span class="red">
                                    {{ $currency -> current_price }} EUR
                                </span>
                            @else
                                {{ $currency -> current_price }} EUR
                            @endif
                        </p>

                    </div> <!-- currency_container -->

                </a>

            @endforeach





        </div> <!-- currencies_container -->

     </div><!-- wrap -->


<script src="{{ asset('js/index.js') }}"></script>
</body>
</html>
