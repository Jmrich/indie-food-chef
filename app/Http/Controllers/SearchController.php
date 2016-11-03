<?php

namespace App\Http\Controllers;

use App\Geocoder;
use App\KitchenAddress;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Search for chefs by location
     *
     * @param Request $request
     * @return string
     */
    public function byLocation(Request $request)
    {
        \Session::put('searchUrl', $request->fullUrl());

        $response = Geocoder::geocode($request->address);

        $lat = $response['results'][0]['geometry']['location']['lat'];

        $lng = $response['results'][0]['geometry']['location']['lng'];

        $formatted_address = $response['results'][0]['formatted_address'];

        $distance = 10;

        $miles = 3959;

        $km = 6371;

        $select_statement = "select * , ( ? * acos( cos( radians(?) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(?) ) + sin( radians(?) ) * sin( radians( lat ) ) ) ) AS distance from kitchen_addresses HAVING distance < ? ORDER BY distance";

        $kitchens = KitchenAddress::hydrateRaw($select_statement, [$miles, $lat, $lng, $lat, $distance])
            ->transform(function ($address) {
                return $address->kitchen;
            });

        return view('search.kitchen-list', compact('kitchens'));
    }
}
