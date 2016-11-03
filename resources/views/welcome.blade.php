
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <h3>Welcome to Indie Food Chef!</h3>
    </div>
    <div class="row">
        <restaurant-search inline-template>
            <form role="form">
                <div class="form-group">
                    <label for="address">Enter your address</label>
                    <input id="address" name="address" v-model="address" class="form-control" type="text" placeholder="Street address, city, state">
                </div>

                <div class="form-group">
                    <button class="btn btn-primary" @click.prevent="restaurantSearch" :disabled="! address.length">Search</button>
                </div>
            </form>
        </restaurant-search>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <strong>How it works section</strong>
        <p>Finding an independent chef has never been easier!</p>
    </div>
    <div class="row">
        <p>This will be section on the service and why they should order from an indie chef</p>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        function initAutocomplete() {
            // Create the autocomplete object, restricting the search to geographical
            // location types.
            autocomplete = new google.maps.places.Autocomplete(
                    /** @type {!HTMLInputElement} */(document.getElementById('address')),
                    {types: ['geocode']});

            // When the user selects an address from the dropdown, populate the address
            // fields in the form.
            //autocomplete.addListener('place_changed', fillInAddress);
        }
    </script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ env('GMAPS_KEY') }}&libraries=places&callback=initAutocomplete" async defer></script>
@endsection
