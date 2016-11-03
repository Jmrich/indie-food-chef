<add-payment-method
        :customer="customer"
        :user="user" inline-template>
    <div class="panel panel-info">

        <div class="panel-body">
            <div class="alert alert-success" v-if="form.successful">
                Your payment method has been updated!
            </div>
            <div class="row col-md-offset-2" v-if="customer.stripe_id">
                <h4>Current payment method: @{{ customer.card_brand }} ending in @{{ customer.card_last_four }}</h4>
            </div>
            <form class="form-horizontal" role="form">
                <!-- Cardholder's Name -->
                <div class="form-group">
                    <label for="name" class="col-md-2 control-label">Cardholder's Name</label>

                    <div class="col-md-6">
                        <input type="text" class="form-control" :value="user.name" name="name" v-model="addCardForm.name">
                    </div>
                </div>

                <!-- Card Number -->
                <div class="form-group" :class="{'has-error': addCardForm.errors.has('number')}">
                    <label class="col-md-2 control-label">Card Number</label>

                    <div class="col-md-6">
                        <input type="text" class="form-control" name="number" data-stripe="number" v-model="addCardForm.number">

                        <span class="help-block" v-show="addCardForm.errors.has('number')">
                @{{ addCardForm.errors.get('number') }}
            </span>
                    </div>
                </div>

                <!-- Security Code -->
                <div class="form-group">
                    <label class="col-md-2 control-label">Security Code</label>

                    <div class="col-md-6">
                        <input type="text" class="form-control" name="cvc" data-stripe="cvc" v-model="addCardForm.cvc">
                    </div>
                </div>

                <!-- Expiration -->
                <div class="form-group">
                    <label class="col-md-2 control-label">Expiration</label>

                    <!-- Month -->
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="month"
                               placeholder="MM" maxlength="2" data-stripe="exp-month" v-model="addCardForm.month">
                    </div>

                    <!-- Year -->
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="year"
                               placeholder="YYYY" maxlength="4" data-stripe="exp-year" v-model="addCardForm.year">
                    </div>
                </div>

                <!-- ZIP Code -->
                <div class="form-group">
                    <label class="col-md-2 control-label">ZIP / Postal Code</label>

                    <div class="col-md-6">
                        <input type="text" class="form-control" name="zip" v-model="form.zip">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-2">
                        <button type="button" class="btn btn-success" @click="addCard" value='some text'>
                            <template v-if="customer.stripe_id">Update</template>
                            <template v-else>Add Card</template>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</add-payment-method>