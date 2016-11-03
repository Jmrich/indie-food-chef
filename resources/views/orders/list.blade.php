@extends('layouts.app')

@section('content')
    <div class="col-md-12">
        <div class="panel panel-default panel-flush">
            <div class="panel-heading">
                Order History
            </div>

            <div class="panel-body">

                @foreach($orders as $order)
                    <h3>Kitchen: <a href="{{ route('kitchens.show', [$order->kitchen]) }}">{{ $order->kitchen->name }}</a> </h3>
                    <h4>Order Date: {{ $order->created_at }}</h4>
                    <h4>Order Id: {{ $order->id }}</h4>
                    <a href="{{ route('orders.show', [$order]) }}" class="btn btn-primary">More Details</a>
                    {{--@foreach($order->dishes as $dish)
                        Dish Name: {{ $dish->name }}<br>
                        Price: {{ $dish->price }}
                    @endforeach
                    <h5>Subtotal: {{ $order->subtotal }}</h5>
                    <h5>Tax: {{ $order->tax }}</h5>
                    <h5>Total: {{ $order->total }}</h5>--}}
                    <hr>
                @endforeach

                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection