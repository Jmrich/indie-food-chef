{{--
<food-bag :user="user" :kitchen="kitchen" inline-template>
--}}
    <div class="panel panel-default">
        @include('modals.bag.edit-dish-modal')
        <div class="panel-heading">
            <h3 class="panel-title">Food Bag</h3>
        </div>
        <div class="panel-body" style="height: 100%; min-height: 100%">
            <template v-if="bagForm.bag.items.length < 1">
                <div class="row">
                    <p>Your bag is currently empty</p>
                </div>
                <template v-if="bagForm.bag.pickupOrDelivery == 'delivery'">
                    <div class="row">
                        <div class="col-md-5">
                            Delivery Fee:
                        </div>
                        <div class="col-md-3 text-right">
                            @{{ filters.currency(kitchen.delivery_fee/100) }}
                        </div>
                    </div>
                </template>
            </template>
            <div class="row" v-for="(item,index) in bagForm.bag.items">
                <div class="col-md-1">
                    <i class="fa fa-times" aria-hidden="true" @click='removeItemFromBag(item)'></i>
                </div>
                <div class="col-md-1">
                    <i class="fa fa-pencil" aria-hidden="true" @click='editItemInBag(item, index)'></i>
                </div>
                <div class="col-md-2 bag-dish-quantity">
                    @{{ item.quantity }}
                </div>
                <div class="col-md-4 bag-dish-name">
                    @{{ item.name }}
                </div>
                <div class="col-md-3 bag-dish-price">
                    @{{ filters.currency((item.quantity*item.price)/100) }}
                </div>
            </div>
            <br>
            <div id="pricing-div" v-show="bagForm.bag.items.length > 0">
                <div class="row">
                    <div class="col-md-5">
                        Subtotal:
                    </div>
                    <div class="col-md-3 text-right">
                        @{{ filters.currency(bagForm.bag.subtotal/100) }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        Tax:
                    </div>
                    <div class="col-md-3 text-right">
                        @{{ filters.currency(bagForm.bag.tax/100) }}
                    </div>
                </div>
                <template v-if="bagForm.bag.pickupOrDelivery == 'delivery'">
                    <div class="row">
                        <div class="col-md-5">
                            Delivery Fee:
                        </div>
                        <div class="col-md-3 text-right">
                            @{{ filters.currency(bagForm.bag.kitchen.delivery_fee/100) }}
                        </div>
                    </div>
                </template>
                <div class="row">
                    <div class="col-md-5">
                        Total:
                    </div>
                    <div class="col-md-3 text-right">
                        @{{ filters.currency(bagForm.bag.total/100) }}
                    </div>
                </div>
            </div>
            <div id="checkout" v-show="bagForm.bag.items.length > 0">
                <div class="row">
                    <button class="btn btn-primary" id="checkout-button" type="button" @click="checkout">Checkout</button>
                </div>
            </div>
        </div>
    </div>
{{--
</food-bag>--}}
