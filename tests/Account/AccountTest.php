<?php

use App\Customer;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AccountTest extends TestCase
{
    /** @test */
    public function it_can_reach_account_page()
    {
        $customer = Customer::first();

        $this->actingAs($customer->user)
            ->visit(route('profile'))
            ->seePageIs('/account/profile');
    }

    /** @test */
    public function it_can_see_the_users_name()
    {
        $customer = Customer::first();

        $this->actingAs($customer->user)
            ->visit(route('profile'))
            ->see($customer->user->name);
    }
}
