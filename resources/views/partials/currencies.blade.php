@foreach($response as $currency)

    <a href="/currency/{{ $currency -> id }}">
        <div class="currency_container" data-id="{{ $currency -> id }}">


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
