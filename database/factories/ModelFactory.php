<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use App\Geocoder;

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt('password'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Chef::class, function (Faker\Generator $faker) {
    return [

    ];
});

$factory->define(App\Customer::class, function (Faker\Generator $faker) {
    return [

    ];
});

$factory->define(App\CustomerAddress::class, function (Faker\Generator $faker) {
    $address = collect(['90254', '90505', '90250', '90278', '90501', '90503', '90502', '90260', '90249'])->random();

    $coordinates = Geocoder::geocode($address);

    $lat = $coordinates['results'][0]['geometry']['location']['lat'];

    $lng = $coordinates['results'][0]['geometry']['location']['lng'];

    return [
        'place_id' => $coordinates['results'][0]['place_id'],
        'lat' => $lat,
        'lng' => $lng,
        'address' => '',
        'address_line_2' => '',
        'city' => '',
        'zip' => '',
        'country' => '',
        'default' => '',
        'formatted_address' => $coordinates['results'][0]['formatted_address']
    ];
});

$factory->define(App\KitchenAddress::class, function (Faker\Generator $faker) {
    $address = collect(['90254', '90505', '90250', '90278', '90501', '90503', '90502', '90260', '90249'])->random();

    $coordinates = Geocoder::geocode($address);

    $lat = $coordinates['results'][0]['geometry']['location']['lat'];

    $lng = $coordinates['results'][0]['geometry']['location']['lng'];

    return [
        'place_id' => $coordinates['results'][0]['place_id'],
        'lat' => $lat,
        'lng' => $lng,
        'address' => '',
        'address_line_2' => '',
        'city' => '',
        'zip' => '',
        'country' => '',
        'formatted_address' => $coordinates['results'][0]['formatted_address']
    ];
});

$factory->define(App\Address::class, function (Faker\Generator $faker) {
    $address = collect(['90254', '90505', '90250', '90278', '90501', '90503', '90502', '90260', '90249'])->random();

    $coordinates = Geocoder::geocode($address);

    $lat = $coordinates['results'][0]['geometry']['location']['lat'];

    $lng = $coordinates['results'][0]['geometry']['location']['lng'];

    return [
        'place_id' => $coordinates['results'][0]['place_id'],
        'lat' => $lat,
        'lng' => $lng,
        'address' => '',
        'address_line_2' => '',
        'city' => '',
        'zip' => '',
        'country' => '',
        'formatted_address' => $coordinates['results'][0]['formatted_address']
    ];
});

$factory->define(App\Dish::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(),
        'price' => $faker->numberBetween(1000, 4000),
    ];
});

$factory->define(App\Kitchen::class, function (Faker\Generator $faker) {
    $name = $faker->company;

    return [
        'name' => $name,
        'slug' => str_slug($name),
        'email' => $faker->unique()->safeEmail,
        'timezone' => 'America/Los_Angeles',
        'is_active' => 1,
        'stripe_public_key' => 'pk_test_IviahuRqoBfBQ4GaiCtAnQKY',
        'stripe_secret_key' => 'sk_test_ui48LBKyYHsVNm4wkm5HzQ7P'
    ];
});

$factory->define(App\Menu::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->sentence(),
        'day_of_week' => '',
        'cutoff_time' => '14:30:00',
    ];
});

$factory->define(App\Category::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word
    ];
});

$factory->define(App\PaymentMethod::class, function (Faker\Generator $faker) {
    return [
        'source_id' => $faker->word,
        'card_brand' => $faker->word,
        'last_four' => $faker->randomNumber(4),
        'zip_code' => $faker->postcode,
    ];
});