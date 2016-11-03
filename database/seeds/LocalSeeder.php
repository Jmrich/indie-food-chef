<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LocalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 3)->create()->each(function ($user) {
            $chef = factory(App\Chef::class)->create();

            $chef->user()->save($user);

            $kitchen = $chef->kitchen()->save(factory(App\Kitchen::class)->make());

            // Create Stripe account
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            $account = \Stripe\Account::create(array(
                "country" => "US",
                "managed" => false,
                "email" => $chef->user->email
            ));

            $kitchen->forceFill([
                'stripe_id' => $account->id,
                'stripe_secret_key' => $account->keys['secret'],
                'stripe_public_key' => $account->keys['publishable']
            ])->save();

            $kitchen->addresses()->save(factory(App\KitchenAddress::class)->make([
                'pickup_location' => 1,
                'kitchen_id' => $kitchen->id
            ]));

            $this->makeMenusAndDishes($kitchen);

            /*factory(App\Dish::class, 10)->create(['kitchen_id' => $kitchen->id])
                ->each(function ($dish) use ($menu) {
                    $dish->menus()->save($menu);
                });*/
        });

        factory(App\User::class, 5)->create()->each(function ($user, $key) {
            if ($key == 0) {
                $user->update(['email' => 'lakers0884@gmail.com']);
            }

            $customer = factory(App\Customer::class)->create();

            $customer->user()->save($user);
        });
    }

    protected function makeMenusAndDishes($kitchen)
    {
        collect(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'])
            ->each(function ($day, $key) use ($kitchen) {
                $menu = $kitchen->menus()->save(factory(App\Menu::class)->make([
                    'name' => $day,
                    'description' => "Menu for $day",
                    'day_of_week' => $key,
                    'is_active' => 1
                ]));

                $dish = factory(App\Dish::class)->create(['kitchen_id' => $kitchen->id]);

                $dish->menus()->save($menu, [
                    'start_date' => '2016-10-23',
                    'end_date' => '2017-10-23',
                    'starting_quantity' => 20,
                    'quantity_remaining' => 20
                ]);
            });
    }
}
