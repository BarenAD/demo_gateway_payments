<table id="currencies">
    <thead>
        <tr>
            <th>
                {{ Lang::get('Currency') }}
            </th>
            @foreach($currencies as $currency)
                <th title="{{ $currency->name }}">
                    {{ $currency->identify }} | X -> Y(1)
                </th>
            @endforeach
        </tr>
    </thead>
    <form
        action="{{ route('currencies.sync') }}"
        method="POST"
    >
        {{ csrf_field() }}
        <button type="submit">SYNC</button>
    </form>
    <tbody>
        @foreach($currencies as $currency)
            <tr>
                <th title=" {{ $currency->name }}" style="white-space: nowrap">
                    {{ $currency->identify }} | Y(1) -> X
                </th>
                @foreach($currencies as $currencyRate)
                    @if($currencyRate->identify === $currency->identify)
                        <td title=" {{ $currencyRate->name }}">
                            1
                        </td>
                    @else
                        <td title=" {{ $currencyRate->name }}">
                            {{ $currencyRate->from_rates->where('currency_from_id', $currency->id)->first()->value }}
                        </td>
                    @endif
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>

<style>
    #currencies {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #currencies td, #currencies th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #currencies tr:nth-child(even){background-color: #f2f2f2;}

    #currencies tr:hover {background-color: #ddd;}

    #currencies th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #04AA6D;
        color: white;
    }
</style>
