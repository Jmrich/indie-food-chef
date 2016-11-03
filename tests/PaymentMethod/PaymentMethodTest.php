<?php

use App\Customer;
use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Stripe\Stripe;
use Stripe\Token;

class PaymentMethodTest extends TestCase
{
    //use DatabaseMigrations;

    /** @test */
    public function user_can_add_a_new_payment_method()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $token = Token::create(array(
            "card" => array(
                "number" => "4242424242424242",
                "exp_month" => 8,
                "exp_year" => 2017,
                "cvc" => "314"
            )
        ));

        $user = Customer::first()->user;

        $this->actingAs($user)
            ->json('POST', route('payment-methods.store'), ['stripe_token' => $token->id]);

        $this->assertResponseStatus(200);
    }

    /** @test */
    public function stripe_token_required()
    {
        $user = factory(App\User::class)->create();

        $response = $this->actingAs($user)
            ->json('POST', route('payment-methods.store'), []);

        $this->assertResponseStatus(422);
    }
}
