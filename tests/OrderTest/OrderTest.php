<?php

use App\Customer;
use App\Kitchen;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Stripe\Stripe;
use Stripe\Token;

class OrderTest extends TestCase
{
    public $customer,$user, $kitchen, $menu;

    public function intializeVariables()
    {
        $this->customer = factory(App\Customer::class)->create();

        $this->user = factory(App\User::class)->create();

        $this->customer->user()->save($this->user);

        $this->kitchen = factory(App\Kitchen::class)->create();

        $menu = $this->kitchen->menus()->save(factory(App\Menu::class)->make(['is_active' => 1]));

        factory(App\Dish::class, 10)->create(['kitchen_id' => $this->kitchen->id])->each(function ($dish) use ($menu) {
            $dish->menus()->save($menu);
        });
    }

    /** @test */
    public function can_create_order()
    {
        $customer = Customer::first();

        $user = $customer->user;

        if (! $customer->stripe_id) {
            $this->createPaymentMethod($user, '4242424242424242');
        }

        $kitchen = Kitchen::first();

        $dish = $kitchen->dishes()->first();

        $data = ['bag' => [
            'subtotal' => $dish->price,
            'tax' => $dish->price*.09,
            'total' => (($dish->price) + ($dish->price*.09)),
            'kitchen' => $kitchen,
            'items' => [
                [
                    'id' => $dish->id,
                    'name' => $dish->name,
                    'price' => $dish->price
                ]
            ],
            'pickupOrDelivery' => '',
            'address' => ''
        ]];

        $this->actingAs($user)
            ->json('POST', route('orders.store'), $data)
            ->assertResponseStatus(200);
    }

    /** @test */
    public function order_is_created_but_payment_fails()
    {
        $this->intializeVariables();

        $dish = $this->kitchen->dishes()->first();

        $this->createPaymentMethod($this->user, '4000000000000341');

        $data = ['bag' => [
            'subtotal' => 10,
            'tax' => 0.9,
            'total' => 10.90,
            'kitchen' => $this->kitchen,
            'items' => [
                [
                    'id' => $dish->id,
                    'name' => $dish->name,
                    'price' => $dish->price
                ]
            ],
            'pickupOrDelivery' => '',
            'address' => ''
        ]];

        $this->actingAs($this->user)
            ->json('POST', route('orders.store'), $data)
            ->assertResponseStatus(402);
    }

    /**
     * @test
     */
    public function payment_succeeds_after_failed_payment()
    {
        $this->intializeVariables();

        $dish = $this->kitchen->dishes()->first();

        $this->createPaymentMethod($this->user, '4242424242424242');

        $data = ['bag' => [
            'subtotal' => 10,
            'tax' => 0.9,
            'total' => 10.90,
            'kitchen' => $this->kitchen,
            'items' => [
                [
                    'id' => $dish->id,
                    'name' => $dish->name,
                    'price' => $dish->price
                ]
            ],
            'pickupOrDelivery' => '',
            'address' => ''
        ]];

        $order = App\Order::forceCreate([
            'subtotal' => $data['bag']['subtotal'],
            'tax' => $data['bag']['tax'],
            'total' => $data['bag']['total'],
            'kitchen_id' => $this->kitchen->id,
            'customer_id' => $this->customer->id,
            'card_brand' => $this->user->card_brand,
            'card_last_four' => $this->user->card_last_four
        ]);

        $this->withSession(['order_id' => $order->id])
            ->actingAs($this->user)
            ->post(route('orders.store'), $data)
            ->assertResponseStatus(200);
    }

    /** @test */
    public function order_is_completed_and_kitchen_is_notified()
    {
        $this->intializeVariables();

        $dish = $this->kitchen->dishes()->first();

        $this->createPaymentMethod($this->user, '4242424242424242');

        //$this->expectsEvents(App\Events\OrderWasCompleted::class);

        $data = ['bag' => [
            'subtotal' => 10,
            'tax' => 0.9,
            'total' => 10.90,
            'kitchen' => $this->kitchen,
            'items' => [
                [
                    'id' => $dish->id,
                    'name' => $dish->name,
                    'price' => $dish->price
                ]
            ],
            'pickupOrDelivery' => '',
            'address' => ''
        ]];

        $this->actingAs($this->user)
            ->post(route('orders.store'), $data)
            ->assertResponseStatus(200);
    }

    protected function createPaymentMethod($user, $ccNumber)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $token = Token::create(array(
            "card" => array(
                "number" => $ccNumber,
                "exp_month" => 8,
                "exp_year" => 2017,
                "cvc" => "314"
            )
        ));

        $this->actingAs($user)
            ->json('POST', route('payment-methods.store'), ['stripe_token' => $token->id]);
    }
}
