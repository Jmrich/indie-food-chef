@extends('layouts.app')

@section('content')
    <div class="panel panel-default col-md-8 col-md-offset-2">
        <div class="panel-heading">
            <ul class="list-inline panel-title">
                <li>Order {{ $order->id }}</li>
                <li><a href="{{ url('/chef/orders') }}" class="btn btn-primary btn-sm">Back</a> </li>
                <li><button class="btn" onClick="window.print()">Print this page</button></li>
            </ul>
            <h3 class="panel-title"></h3>
        </div>
        <div class="panel-body">
            @each('chef.orders.order-details', $order->dishes, 'dish')
            <dl class="dl-horizontal">
                <dt>Subtotal:</dt>
                <dd>${{ $order->subtotal/100 }}</dd>
                <dt>Tax:</dt>
                <dd>${{ $order->tax/100 }}</dd>
                @if($order->delivery)
                    <dt>Delivery Fee:</dt>
                    <dd>${{ $order->delivery_fee/100 }}</dd>
                @endif
                <dt>Price:</dt>
                <dd>${{ $order->total/100 }}</dd>
            </dl>
            <div class="row col-md-offset-2">
                @if(!$order->is_complete)
                    <div class="col-md-8">
                        <form id="cancel-order" action="{{ route('cancel-order', [$order]) }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                        <form id="complete-order" action="{{ route('complete-order', [$order]) }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                        <button type="button" class="btn btn-danger" onclick="document.getElementById('cancel-order').submit();">
                            Cancel Order
                        </button>
                        <button type="button" class="btn btn-success" onclick="document.getElementById('complete-order').submit();">
                            Complete Order
                        </button>
                    </div>
                @elseif (!$order->was_refunded)
                    <div class="col-md-8">
                        <form id="refund-order" action="{{ route('refund-order', [$order]) }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                        <button type="button" class="btn btn-danger" onclick="document.getElementById('refund-order').submit();">
                            Refund Order
                        </button>
                    </div>
                @else
                    <h3>Order Refunded</h3>
                @endif
            </div>
        </div>
    </div>
@endsection