@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Order <a href="{{ url('/orders') }}" class="btn btn-primary">Back</a> </div>

                <div class="panel-body">
                    Order Contents
                    @foreach($dishes as $dish)
                        <div>
                            <h4>{{ $dish['main_dish']['name'] }}</h4>
                            <h4>Description: {{ $dish['main_dish']['description'] }}</h4>
                            <h4>Price: {{ $dish['main_dish']['price']/100 }}</h4>
                            <h4>Notes: {{ $dish['main_dish']['pivot']['notes'] }}</h4>
                            @if($dish['side_dish'] != '')
                                <h4>Side: {{ $dish['side_dish']['name'] }}</h4>
                                <h4>Notes:</h4>
                            @endif
                        </div>
                        <hr>
                    @endforeach
                    <h4>Subtotal: ${{ $order->subtotal/100 }}</h4>
                    <h4>Tax: ${{ $order->tax/100 }}</h4>
                    @if($order->delivery)
                        <h4>Delivery Fee: ${{ $order->delivery_fee/100 }}</h4>
                    @endif
                    <h4>Total: ${{ $order->total/100 }}</h4>
                </div>
            </div>
        </div>
    </div>
@endsection
