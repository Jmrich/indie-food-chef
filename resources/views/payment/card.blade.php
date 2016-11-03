<form class="form-horizontal" role="form">
    <!-- Cardholder's Name -->
    <div class="form-group">
        <label for="name" class="col-md-4 control-label">Cardholder's Name</label>

        <div class="col-md-6">
            <input type="text" class="form-control" :value="user.name" name="name" v-model="addCardForm.name">
        </div>
    </div>

    <!-- Card Number -->
    <div class="form-group" :class="{'has-error': addCardForm.errors.has('number')}">
        <label class="col-md-4 control-label">Card Number</label>

        <div class="col-md-6">
            <input type="text" class="form-control" name="number" data-stripe="number" v-model="addCardForm.number">

            <span class="help-block" v-show="addCardForm.errors.has('number')">
                @{{ addCardForm.errors.get('number') }}
            </span>
        </div>
    </div>

    <!-- Security Code -->
    <div class="form-group">
        <label class="col-md-4 control-label">Security Code</label>

        <div class="col-md-6">
            <input type="text" class="form-control" name="cvc" data-stripe="cvc" v-model="addCardForm.cvc">
        </div>
    </div>

    <!-- Expiration -->
    <div class="form-group">
        <label class="col-md-4 control-label">Expiration</label>

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
        <label class="col-md-4 control-label">ZIP / Postal Code</label>

        <div class="col-md-6">
            <input type="text" class="form-control" name="zip" v-model="form.zip">
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <button type="button" class="btn btn-success" @click="addCard" :disabled='form.busy'>
                @{{ buttonText }}
            </button>
            <button type="button" v-show="updatingCard" class="btn btn-danger" @click="cancelCardUpdate" :disabled='form.busy'>
            Cancel
            </button>
        </div>
    </div>
</form>