<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Order Summary</h3>
    </div>
    <div class="panel-body" style="height: 100%; min-height: 100%">
        <div class="row" v-for="item in bagForm.bag.items">
            <div class="col-md-2">
                @{{ item.quantity }}
            </div>
            <div class="col-md-4">
                @{{ item.name }}
            </div>
            <div class="col-md-4">
                @{{ filters.currency((item.quantity*item.price)/100) }}
            </div>
            <hr>
        </div>
        <br>
        <div id="pricing-div">
            <div class="row">
                <div class="col-md-6">
                    Subtotal:
                </div>
                <div class="col-md-6 text-right">
                    @{{ filters.currency(bagForm.bag.subtotal/100) }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    Tax:
                </div>
                <div class="col-md-6 text-right">
                    @{{ filters.currency(bagForm.bag.tax/100) }}
                </div>
            </div>
            <div class="row" v-show="delivering">
                <div class="col-md-6">
                    Delivery Fee:
                </div>
                <div class="col-md-6 text-right">
                    @{{ filters.currency(bagForm.bag.kitchen.delivery_fee/100) }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    Total:
                </div>
                <div class="col-md-6 text-right">
                    @{{ filters.currency(bagForm.bag.total/100) }}
                </div>
            </div>
        </div>
        <div class="row">
            <button class="btn btn-primary" @click='modifyOrder'>Modify order</button>
        </div>

        <div class="row">
            <button class="btn btn-success" :disabled="! customer.card_last_four" @click='placeOrder'>Place order</button>
        </div>
    </div>
</div>