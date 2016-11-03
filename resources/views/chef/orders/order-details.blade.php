<dl class="dl-horizontal">
    <dt>Dish:</dt>
    <dd>{{ $dish->name }}</dd>
    <dt>Description:</dt>
    <dd>{{ $dish->description }}</dd>
    <dt>Price:</dt>
    <dd>${{ $dish->price/100 }}</dd>
    <dt>Notes:</dt>
    <dd>
        @if ($dish->main_dish_notes == '')
            N/A
        @else
            {{ $dish->main_dish_notes }}
        @endif
    </dd>
</dl>

{{--
<div>
    <h4>{{ $dish['main_dish']['name'] }}</h4>
    <h4>Description: {{ $dish['main_dish']['description'] }}</h4>
    <h4>Price: {{ $dish['main_dish']['price']/100 }}</h4>
    <h4>Notes: {{ $dish['main_dish']['pivot']['notes'] }}</h4>
    @if($dish['side_dish'] != '')
        <h4>Side: {{ $dish['side_dish']['name'] }}</h4>
        <h4>Notes:</h4>
    @endif
</div>--}}
