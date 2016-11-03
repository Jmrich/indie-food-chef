<?php
use App\Geocoder;
use App\Kitchen;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SearchTest extends SeleniumTestCase
{
    public function test_kitchen_search()
    {
        $address = '2830 W 235th St Torrance';

        $this->visit('/')
            ->see('Welcome to COI')
            ->type($address, 'address')
            ->press('Search')
            ->seePageIs('/search?address=' . urlencode($address));
    }

    /** @test */
    public function kitchen_can_be_selected_after_search()
    {
        $address = '2830 W 235th St Torrance';

        /*$coordinates = Geocoder::geocode($address);

        $lat = $coordinates['lat'];

        $lng = $coordinates['lng'];

        $kitchens = Kitchen::findByLocation($lat, $lng);*/


        $this->visit('/')
            ->see('Welcome to COI')
            ->type($address, 'address')
            ->press('Search')
            ->seePageIs('/search?address=' . urlencode($address));

        $this->byXPath("//*[@id=\"kitchen-list\"]/a[1]")
            ->click();

        $this->assertContains('/kitchens', $this->url());

        //*[@id="kitchen-list"]/a[1]
    }
}