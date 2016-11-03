<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BagTest extends SeleniumTestCase
{
    /** @test */
    public function can_add_item_to_bag()
    {
        $this->initialSetup();

        $dish_name = $this->byCssSelector('.dish-name:first-of-type')->text();

        $this->byCssSelector('.add-dish-to-cart:first-of-type')->click();

        $this->hold(2);

        $bag_dish_name = $this->byCssSelector('.bag-dish-name')->text();

        $this->assertEquals($dish_name, $bag_dish_name);
    }

    /** @test */
    public function can_add_multiple_items_to_bag()
    {
        $this->initialSetup();

        $first_dish = $this->byCssSelector('.dish-name:nth-of-type(1)')->text();

        $this->clickByXPath("//*[@id=\"menu\"]/div[1]/div[3]/div/button");

        $this->hold(2);

        $this->clickByXPath("//*[@id=\"menu\"]/div[2]/div[3]/div/button");

        $this->hold(2);

        $second_dish = $this->byXPath("//*[@id=\"menu\"]/div[1]/div[1]/div[2]")->text();

        $bag_first_dish = $this->byXPath("//*[@id=\"menu\"]/div[1]/div[1]/div[1]")->text();

        $bag_second_dish = $this->byXPath("//*[@id=\"menu\"]/div[1]/div[1]/div[2]")->text();

        $this->assertEquals($first_dish, $bag_first_dish);

        $this->assertEquals($second_dish, $bag_second_dish);
    }

    /** @test */
    public function it_redirects_to_login_when_checkout_pressed_as_guest()
    {
        $this->initialSetup();

        $this->clickByXPath("//*[@id=\"menu\"]/div[1]/div[3]/div/button")->hold(2);

        $this->clickByXPath("//*[@id=\"menu\"]/div[2]/div[3]/div/button")->hold(2);

        $this->press('Checkout')->hold(2);

        $this->seePageIs('/login');
    }

    /** @test */
    public function it_goes_to_order_review_after_logged_in()
    {
        $this->initialSetup();

        $this->clickByXPath("//*[@id=\"menu\"]/div[1]/div[3]/div/button")
            ->hold(2)
            ->clickByXPath("//*[@id=\"menu\"]/div[2]/div[3]/div/button")
            ->hold(2)
            ->press('Checkout')
            ->hold(2)
            ->seePageIs('/login');

        $this->type('morissette.onie@example.net', 'email')
            ->type('password', 'password')
            ->clickByXPath('//*[@id="login-button"]')
            ->seePageIs('/order/review');

        $this->hold(2);

        $this->see('Payment methods');
    }

    protected function initialSetup()
    {
        $address = '2830 W 235th St Torrance';

        $this->visit('/')
            ->see('Welcome to COI')
            ->type($address, 'address')
            ->press('Search')
            ->seePageIs('/search?address=' . urlencode($address));

        $this->hold(2);

        $this->byXPath("//*[@id=\"kitchen-list\"]/a[1]")->click();

        $this->hold(2);
    }
}