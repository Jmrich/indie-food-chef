<update-customer-information
        :customer="customer"
        :user="user" inline-template>
    <div class="panel panel-info">
        {{--<div class="panel-heading">Profile</div>--}}

        <div class="panel-body">
            <div class="alert alert-success" v-if="form.successful">
                Your contact information has been updated!
            </div>
            <form class="form-horizontal" role="form">
                <div class="form-group" :class="{'has-error': form.errors.has('name')}">
                    <label class="col-md-3 control-label">Name</label>

                    <div class="col-md-6">
                        <input type="text" class="form-control" name="name" v-model="form.name">

                        <span class="help-block" v-show="form.errors.has('name')">
                            @{{ form.errors.get('name') }}
                        </span>
                    </div>
                </div>
                <div class="form-group" :class="{'has-error': form.errors.has('email')}">
                    <label class="col-md-3 control-label">Email</label>

                    <div class="col-md-6">
                        <input type="text" class="form-control" name="email" v-model="form.email">

                        <span class="help-block" v-show="form.errors.has('email')">
                            @{{ form.errors.get('email') }}
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-4 col-md-offset-3">
                        <button type="button" @click='update'>Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</update-customer-information>