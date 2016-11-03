@extends('layouts.app')

@section('scripts')
    <script src="https://js.stripe.com/v2/"></script>
@endsection

@section('bottomScript')

@endsection

@section('content')
    <account :user="user" :customer="customer" inline-template>
        <div class="=container">
            <div class="row">
                <!-- Tabs -->
                <div class="col-md-12">
                    <div class="panel panel-default panel-flush">
                        <div class="panel-heading">
                            Settings
                        </div>

                        <div class="panel-body">
                            <div class="">
                                <ul class="nav nav-tabs" role="tablist">
                                    <!-- Profile Link -->
                                    <li class="active" role="presentation">
                                        <a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">
                                            <i class="fa fa-fw fa-btn fa-user"></i>Profile
                                        </a>
                                    </li>

                                <!-- Security Link -->
                                    <li role="presentation">
                                        <a href="#security" aria-controls="security" role="tab" data-toggle="tab">
                                            <i class="fa fa-fw fa-btn fa-lock"></i>Security
                                        </a>
                                    </li>
                                    <!-- Payment Method Link -->
                                    <li role="presentation">
                                        <a href="#payment-method" aria-controls="profile" role="tab" data-toggle="tab">
                                            <i class="fa fa-fw fa-btn fa-credit-card"></i>Payment Method
                                        </a>
                                    </li>
                                    <!-- Address Link -->
                                    <li role="presentation">
                                        <a href="#address" aria-controls="address" role="tab" data-toggle="tab">
                                            <i class="fa fa-fw fa-btn fa-home"></i>Address
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <!-- Profile -->
                                    <div role="tabpanel" class="tab-pane active" id="profile">
                                        @include('account.profile.profile')
                                    </div>

                                    <!-- Security -->
                                    <div role="tabpanel" class="tab-pane" id="security">
                                        @include('account.security.update-password')
                                    </div>

                                    <!-- Payment Method -->
                                    <div role="tabpanel" class="tab-pane" id="payment-method">
                                        @include('account.payment-method.payment-method')
                                    </div>

                                    <!-- Address -->
                                    <div role="tabpanel" class="tab-pane" id="address">
                                        @include('account.address.address')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab Panels -->
                <div class="col-md-8">

                </div>

            </div>
        </div>
    </account>
@endsection
