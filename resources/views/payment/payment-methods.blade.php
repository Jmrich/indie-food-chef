<div class="row">
    <div class="col-md-6">
        <div v-if="! customer.card_last_four">
            No payment methods on file. Enter new card below
        </div>
        <div v-else>
            <div class="alert alert-success" v-if="form.successful">
                @{{ alertText }}
            </div>

            <!-- Payment failed -->
            <div class="alert alert-danger" v-if="form.errors.has('payment_error')">
                We had trouble updating your card. It's possible your card provider is preventing
                us from charging the card. Please contact your card provider or customer support.
            </div>
            <select class="form-control">
                <option value="">@{{ customer.card_brand }} - @{{ customer.card_last_four }}</option>
            </select>
            <button type="button" class="btn btn-info" :disabled="showCardForm" @click='updateCard'>Change payment method</button>
        </div>
    </div>
</div>

<!-- Add new credit card -->
<div class="row" v-show="showCardForm">
    @include('payment.card')
</div>

