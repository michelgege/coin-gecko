
@foreach($currencies as $currency)

    <div class="currency_container" data-id="{{ $currency -> id }}"
         data-rank="{{ $currency -> market_cap_rank }}"
         data-price="{{ $currency -> current_price }}" >

        <img src="{{ $currency -> image }}" alt="{{ $currency -> id }} logo">

        <p class="currency_name">{{ $currency -> name }}</p>
        <p class="currency_price">
            @if($currency -> price_change_percentage_24h > 0)
                <span class="green">
                        {{ $currency -> current_price }} {{ Config::get('vars.currency') }}
                    </span>
            @elseif ($currency -> price_change_percentage_24h < 0)
                <span class="red">
                        {{ $currency -> current_price }} {{ Config::get('vars.currency') }}
                    </span>
            @else
                {{ $currency -> current_price }} {{ Config::get('vars.currency') }}
            @endif
        </p>

        @if(!empty($currency->amount))
            <p class="quantity"> {{ $currency->amount }}</p>
        @else
            <p class="quantity">0</p>
        @endif

        <p class="portfolio_currency_price"><span></span> {{ Config::get('vars.currency') }}</p>


        <form action="{{ route('portfolio-insert') }}" method="post">
            @csrf
            <input type="hidden" name="name" value="{{ $currency -> id }}">
            <input class="amount" type="number" name="amount" placeholder="Quantity" step="0.00000001">
        </form>
    </div>
@endforeach
