<?php

namespace App\Http\Controllers;

use App\Address;
use App\CustomerAddress;
use App\Geocoder;
use Illuminate\Http\Request;

use App\Http\Requests;

class CustomerAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \Auth::user()->userable->addresses;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        // validate the address
        $response = Geocoder::geocode($this->buildAddressString($request->all()));

        if ($response['status'] == 'OK') {
            $zip = collect($response['results'][0]['address_components'])->filter(function ($component) {
                return collect($component['types'])->contains('postal_code');
            })->pluck('short_name')->first();

            // lets make sure the input zip code matches googles zip code
            if ($zip != $request->zip) {
                $request['zip'] = $zip;
            }

            $place_id = $response['results'][0]['place_id'];

            $lat = $response['results'][0]['geometry']['location']['lat'];
            $lng = $response['results'][0]['geometry']['location']['lng'];
            $formatted_address = $response['results'][0]['formatted_address'];

            $address = CustomerAddress::forceCreate(array_merge([
                'place_id' => $place_id,
                'lat' => $lat,
                'lng' => $lng,
                'formatted_address' => $formatted_address
            ], $request->except(['errors', 'busy', 'successful'])));

            \Auth::user()->userable->addresses()->save($address);

            return response('Success');
        }

        return response()->json(['invalid_address' => ['Invalid address']], 422);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  CustomerAddress  $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $address)
    {
        $response = Geocoder::geocode($this->buildAddressString($request->all()));

        if ($response['status'] == 'OK') {
            $zip = collect($response['results'][0]['address_components'])->filter(function ($component) {
                return collect($component['types'])->contains('postal_code');
            })->pluck('short_name')->first();

            // lets make sure the input zip code matches googles zip code
            if ($zip != $request->zip) {
                $request['zip'] = $zip;
            }

            $place_id = $response['results'][0]['place_id'];

            $lat = $response['results'][0]['geometry']['location']['lat'];
            $lng = $response['results'][0]['geometry']['location']['lng'];
            $formatted_address = $response['results'][0]['formatted_address'];

            $address->forceFill(array_merge([
                'place_id' => $place_id,
                'lat' => $lat,
                'lng' => $lng,
                'formatted_address' => $formatted_address
            ], $request->except(['errors', 'busy', 'successful', 'id'])))->save();

            return response('Success');
        }

        return response()->json(['invalid_address' => ['Invalid address']], 422);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CustomerAddress  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy($address)
    {
        if ($address->delete()) {
            return response('Successfully deleted');
        }

        return response('An error occurred while deleting the address', 500);
    }

    protected function buildAddressString(array $data)
    {
        $string = $data['address'] . ' ';

        $string .= empty($data['address_line_2']) ? '' : $data['address_line_2'] . ' ';

        $string .= $data['city'] . ', ' . $data['state'] . ' ' . $data['zip'];

        $string .= empty($data['country']) ? '' : ', ' . $data['country'];

        return $string;
    }
}
