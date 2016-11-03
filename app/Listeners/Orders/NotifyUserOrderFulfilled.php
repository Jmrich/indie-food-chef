<?php

namespace App\Listeners\Orders;

use App\Events\Orders\OrderFulfilled;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyUserOrderFulfilled
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderFulfilled  $event
     * @return void
     */
    public function handle(OrderFulfilled $event)
    {
        //
    }
}
