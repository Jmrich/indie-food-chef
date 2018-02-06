@extends('layouts.app')

@section('content')
    <order-list :user="user" :chef="chef" :orders="{{ $orders }}" inline-template>
        <div>
            <div class="panel panel-default col-md-8 col-md-offset-2">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a data-toggle="collapse" href="#pending">Pending Orders</a>
                    </h3>
                </div>
                <div id="pending" class="panel-collapse collapse in">
                    <table class="table">
                        <th>Customer</th><th>Order Date</th><th>Details</th>
                        <tbody v-for="order in pendingOrders">
                            <tr>
                                <td>@{{ order.customer.user.name }}</td>
                                <td>@{{ order.created_at }}</td>
                                <td><a :href="orderUrl(order)">Details</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="panel panel-default col-md-8 col-md-offset-2">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a data-toggle="collapse" href="#completed">Completed Orders</a>
                    </h3>
                </div>
                <div id="completed" class="panel-collapse collapse in">
                    <table class="table">
                        <th>Customer</th><th>Completed Date</th><th>Details</th>
                        <tbody v-for="order in completedOrders">
                            <tr>
                                <td>@{{ order.customer.user.name }}</td>
                                <td>@{{ order.updated_at }}</td>
                                <td><a :href="orderUrl(order)">Details</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </order-list>
@endsection