<?php
/**
 * Created by PhpStorm.
 * User: jmrichardsonjr
 * Date: 7/29/16
 * Time: 6:33 AM
 */

namespace App;


class Geocoder
{
    /**
     * Get coordinates from address
     *
     * @param $address
     * @return array|bool
     */
    public static function geocode($address)
    {
        // google map geocode api url
        $url = static::apiUrlString(urlencode($address));

        // get the json response
        $response = json_decode(file_get_contents($url), true);

        return $response;

        if ($response['status'] == 'OK') {
            // get the important data
            $lat = $response['results'][0]['geometry']['location']['lat'];
            $lng = $response['results'][0]['geometry']['location']['lng'];
            $formatted_address = $response['results'][0]['formatted_address'];

            // verify if data is complete
            if ($lat && $lng && $formatted_address) {
                if (in_array($response['results'][0]['types'][0], static::addressTypes())) {
                    // store address
                    /*Address::forceCreate([
                        'place_id' => $response['results'][0]['place_id'],
                        'lat' => $lat,
                        'lng' => $lng,
                        'formatted_address' => $formatted_address
                    ]);*/
                }

                return [
                    'lat' => $lat,
                    'lng' => $lng,
                    'formatted_address' => $formatted_address,
                    'place_id' => $response['results'][0]['place_id']
                ];
            }
        }

        return false;
    }

    /**
     * Get google maps api url
     *
     * @param $address
     * @return string
     */
    protected static function apiUrlString($address)
    {
        return "https://maps.google.com/maps/api/geocode/json?address={$address}&key=" . env('GMAPS_KEY');
    }

    protected static function addressTypes()
    {
        return ['premise', 'subpremise', 'street_address'];
    }
}