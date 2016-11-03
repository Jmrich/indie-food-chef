<address-list :user="user" :customer="customer" :addresses="{{ Auth::user()->userable->addresses }}" inline-template>
    <!-- End Address Modals -->
    <div class="panel panel-default">
        <div class="">
            {{--<div class="row">
                <div class="col-md-2 pull-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addAddress">Add New Address</button>
                </div>
            </div>--}}
            <div class="col-md-6">
                <table class="table">
                    <tr>
                        <th colspan="3">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addAddress">Add New Address</button>
                        </th>
                    </tr>
                    <template v-if="addresses.length">
                        <tbody v-for="address in addressCollection">
                        <tr>
                            <td class="col-md-8">@{{ address.formatted_address }}</td>
                            <td class="col-md-1">
                                <i class="fa fa-pencil-square-o fa-lg" aria-hidden="true" @click='showEditAddress(address)'></i>
                            </td>
                            <td class="col-md-1"><i class="fa fa-times" aria-hidden="true" @click='removeAddress(address)'></i></td>
                        </tr>
                        </tbody>
                    </template>
                    <template v-else>
                        <tbody>
                        <tr>
                            <td class="col-md-8"><h4>No addresses on file</h4></td>
                        </tr>
                        </tbody>
                    </template>
                </table>
            </div>
        </div>
        <!-- Address Modals -->
        @include('account.address.address-add')
        @include('account.address.address-edit')
    </div>
</address-list>