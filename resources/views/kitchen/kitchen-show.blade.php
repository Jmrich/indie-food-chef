@extends('layouts.app')

@section('content')
    <kitchen-show
            :kitchen="{{ $kitchen }}"
            :menus="{{ $menus }}"
            :hours="{{ $kitchen->hours }}" inline-template>

        <div class="row">
            <div class="col-md-8">
                {{--<div style="min-height: 200px; background-color: #c9edc2">
                    <div class="row">
                        <a href="{{ Session::get('searchUrl') }}">Back to search</a>
                        @{{ kitchen.name }}<br>

                    </div>
                    <div class="row">
                        Hours:
                        <ul>
                            <li v-for="hour in hours">@{{ hour.open }} - @{{ hour.closed }}</li>
                        </ul>
                    </div>
                </div>--}}

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <ul class="list-inline">
                            <li class="panel-title">@{{ kitchen.name }}</li>
                            <li>|</li>
                            <li><a href="{{ Session::get('searchUrl') }}">Back to search</a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        {{--<div class="row">
                            Hours:
                            <ul>
                                <li v-for="hour in hours">@{{ hour.open }} - @{{ hour.closed }}</li>
                            </ul>
                        </div>--}}

                        <div class="row">
                            Pickup Location: @{{ kitchen.addresses[0].formatted_address }}
                        </div>
                        <div class="row" v-if="kitchen.delivery_fee > 0">
                            <p>Delivery Fee: <strong class="text-danger">@{{ filters.currency(kitchen.delivery_fee/100) }}</strong></p>
                        </div>
                        <div class="row">
                            Select delivery or pickup
                            <!-- Delivery or pickup -->
                            <div>
                                <label class="radio-inline">
                                    <input type="radio" name="optradio" value="pickup" v-model="bagForm.bag.pickupOrDelivery" @change='updateDeliveryOption()'>Pickup
                                </label>
                            </div>
                            <div v-show="kitchen.delivers">
                                <label class="radio-inline">
                                    <input type="radio" name="optradio" value="delivery" v-model="bagForm.bag.pickupOrDelivery" @change='updateDeliveryOption()'>Delivery
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel-group" style="padding-top: 10px">
                    <div class="panel panel-default" v-for="(menu,menu_index) in menus">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <ul class="list-inline">
                                    <li>
                                        <a data-toggle="collapse" :href="'#collapse' + menu_index">@{{ menu.name }}</a>
                                    </li>
                                    <li>|</li>
                                    <li style="color: red">Order Cutoff Time - @{{ filters.time(menu.cutoff_time) }}</li>
                                </ul>
                            </h4>
                        </div>
                        <div :id="'collapse' + menu_index" class="panel-collapse collapse in">
                            <div class="panel-body" id="menu">
                                <template v-if="menu.dishes.length > 0">
                                    <template v-for="(dish,dish_index) in menu.dishes">
                                        <div class="col-md-3">
                                            <!-- Dish Image Modal -->
                                            @include('modals.chef.dish.full-image')

                                            <img class="img-thumbnail" :src="dish.image_url" data-toggle="modal" :data-target="'#image-modal-' + menu.id + '-' + dish.id">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row" style="padding: 10px">
                                                <div class="col-md-6 dish-name">
                                                    @{{ dish.name }}
                                                </div>
                                                <div class="col-md-3 dish-price">
                                                    <strong>@{{ filters.currency(dish.price/100) }}</strong>
                                                </div>
                                            </div>
                                            <div class="row" style="padding: 10px">
                                                <div class="col-md-6 dish-description">
                                                    @{{ dish.description }}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <button type="button" data-toggle="modal" :data-target="'#dish-modal-' + menu.id + '-' + dish.id" class="btn btn-primary add-dish-to-cart" :disabled='dayHasPassed(menu.day_of_week)'>Details</button>
                                                </div>
                                                @include('modals.bag.add-dish-modal')
                                            </div>
                                        </div>
                                    </template>
                                </template>
                                <template v-else>
                                    <div>
                                        <strong>No dishes for today</strong>
                                    </div>
                                </template>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="">
                    @include('bag.food-bag')
                </div>
            </div>
        </div>
    </kitchen-show>
@endsection
