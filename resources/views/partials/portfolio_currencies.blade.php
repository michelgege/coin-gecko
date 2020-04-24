
@foreach($currencies as $currency)
    <div class="currency_container" data-id="{{ $currency -> id }}"
         data-rank="{{ $currency -> market_cap_rank }}"
         data-price="{{ $currency -> current_price }}" >

        <img src="{{ $currency -> image }}" alt="{{ $currency -> id }} logo">

        <p class="currency_name">{{ $currency -> name }}</p>

        @if(!empty($currency->amount))
            <p class="quantity"> {{ $currency->amount }}</p>
        @else
            <p class="quantity">0</p>
        @endif

        <form action="{{ route('portfolio-insert') }}" method="post">
            @csrf
            <input type="hidden" name="name" value="{{ $currency -> id }}">
            <input class="amount" type="number" name="amount" placeholder="Quantity" step="0.00000001">
        </form>
    </div>
@endforeach
