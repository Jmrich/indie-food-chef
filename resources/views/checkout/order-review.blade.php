@extends('layouts.app')

@section('scripts')
    <script src="https://js.stripe.com/v2/"></script>
@endsection

@section('content')
    <bag-summary
            :customer="customer"
            :user="user"
            :addresses="{{ $customer->addresses }}"
            :kitchen="{{ $kitchen }}" inline-template>
        <div class="container">
            <div class="alert alert-danger" v-if="bagForm.errors.has('order_error')">
                <h5>@{{ bagForm.errors.get('order_error') }}</h5>
            </div>
            <!-- Payment Method -->
            <div class="col-md-7">
                <add-payment-method :user="user" :customer="customer" inline-template>
                    <div class="row">
                        <div class="panel panel-default">
                            <div class="panel-heading">Payment Method</div>

                            <div class="panel-body">
                                @include('payment.payment-methods')
                            </div>
                        </div>
                    </div>
                </add-payment-method>

                <div class="row" v-show="delivering">
                    <div class="panel panel-default">
                        <div class="panel-heading">Select delivery address</div>

                        <div class="panel-body">
                            <div class="row">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addAddress">Add New Address</button>
                                @include('account.address.address-add')
                            </div>
                            <!-- Customer addresses -->
                            <div class="row">
                                <div v-for="address in addressCollection">
                                    <label class="radio-inline">
                                        <input type="radio" name="address" :value="address" v-model="defaultAddress">@{{ address.formatted_address }}
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-md-offset-1">
                <div class="row">
                    @include('bag.bag-summary')
                </div>
            </div>
        </div>
    </bag-summary>
@endsection