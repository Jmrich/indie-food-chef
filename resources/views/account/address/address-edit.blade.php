<address-edit inline-template>
    <div class="modal fade" id="editAddress" tabindex="-1" role="dialog" aria-labelledby="editAddressLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="editAddressLabel">Update Address</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" v-if="form.errors.has('invalid_address')">
                        <h5>The address supplied is not a valid address</h5>
                    </div>
                    <form role="form" class="form-horizontal">
                        <!-- Address -->
                        <div class="form-group" :class="{'has-error': form.errors.has('address')}">
                            <label class="col-md-4 control-label">Address</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" v-model="form.address">

                                <span class="help-block" v-show="form.errors.has('address')">
                            @{{ form.errors.get('address') }}
                        </span>
                            </div>
                        </div>

                        <!-- Address Line 2 -->
                        <div class="form-group" :class="{'has-error': form.errors.has('address_line_2')}">
                            <label class="col-md-4 control-label">Address Line 2</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" v-model="form.address_line_2">

                                <span class="help-block" v-show="form.errors.has('address_line_2')">
                            @{{ form.errors.get('address_line_2') }}
                        </span>
                            </div>
                        </div>

                        <!-- City -->
                        <div class="form-group" :class="{'has-error': form.errors.has('city')}">
                            <label class="col-md-4 control-label">City</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" v-model="form.city">

                                <span class="help-block" v-show="form.errors.has('city')">
                            @{{ form.errors.get('city') }}
                        </span>
                            </div>
                        </div>

                        <!-- State & ZIP Code -->
                        <div class="form-group" :class="{'has-error': form.errors.has('state')}">
                            <label class="col-md-4 control-label">State & ZIP Code</label>

                            <!-- State -->
                            <div class="col-sm-3">
                                <input type="text" class="form-control" v-model="form.state" placeholder="State">

                                <span class="help-block" v-show="form.errors.has('state')">
                            @{{ form.errors.get('state') }}
                        </span>
                            </div>

                            <!-- Zip Code -->
                            <div class="col-sm-3">
                                <input type="text" class="form-control" v-model="form.zip" placeholder="Postal Code">

                                <span class="help-block" v-show="form.errors.has('zip')">
                            @{{ form.errors.get('zip') }}
                        </span>
                            </div>
                        </div>

                        <!-- Country -->
                        <div class="form-group" :class="{'has-error': form.errors.has('country')}">
                            <label class="col-md-4 control-label">Country</label>

                            <div class="col-sm-6">
                                <select class="form-control" v-model="form.country">
                                    <option>Select a country</option>
                                </select>

                                <span class="help-block" v-show="form.errors.has('country')">
                            @{{ form.errors.get('country') }}
                        </span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="updateAddress">Update</button>
                </div>
            </div>
        </div>
    </div>
</address-edit>