<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"/>

</head>
<body class="portfolio_page">
<div class="wrap">

    <header>
        <h1>My portfolio</h1>
    </header>

    @include('components\nav')
    <div class="line"></div>

    @if($total_price == 0)
        <p>Wow, such empty</p>
    @else
        <p>Your portfolio worth {{ $total_price }} €</p>
    @endif


    <div class="currencies_container">
        @foreach($response as $currency)
            <div class="currency_container" data-id="{{ $currency -> id }}" >

                <img src="{{ $currency -> image }}" alt="logo {{ $currency -> id }}">

                <p class="currency_name">{{ $currency -> name }}</p>

                @if(!empty($portfolio_entries))

                    @foreach($portfolio_entries as $entry)

                        @if($currency->id == $entry->name)
                            <p class="quantity"> {{ $entry->amount }}</p>
                            @php( $found = true )
                            @break
                        @else
                            @php( $found = false )
                        @endif

                    @endforeach

                        @if($found == false)
                            <p class="quantity">0.00000000</p>
                        @endif
                    <form action="{{ route('portfolio-insert') }}" method="post">
                        @csrf
                        <input type="hidden" name="name" value="{{ $currency -> id }}">
                        <input class="amount" type="number" name="amount" placeholder="Quantity" step="0.00000001">
                    </form>

                @else
                    <p class="quantity">0.00000000</p>
                    <form action="{{ route('portfolio-insert') }}" method="post">
                        @csrf
                        <input type="hidden" name="name" value="{{ $currency -> id }}">
                        <input class="amount" type="number" name="amount" placeholder="Quantity" step="0.00000001">
                    </form>
                @endif





            </div>
        @endforeach
    </div>

</div> <!--div.wrap-->

<script src="{{ asset('js/portfolio.js') }}"></script>

</body>
</html>
