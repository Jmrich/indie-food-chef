<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // Order was placed
        'App\Events\Orders\OrderPlaced' => [
            'App\Listeners\Orders\SendOrderToChef',
            'App\Listeners\Orders\SendOrderSummaryToCustomer'
        ],

        'App\Events\Orders\OrderFulfilled' => [
            'App\Listeners\Orders\NotifyUserOrderFulfilled'
        ],

        'App\Events\Orders\OrderCancelled' => [
            'App\Listeners\Orders\NotifyUserOrderCancelled'
        ],

        'App\Events\KitchenWasCreated' => [
            'App\Listeners\CreateMenus'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
