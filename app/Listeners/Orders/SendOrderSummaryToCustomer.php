<?php

namespace App\Listeners\Orders;

use App\Events\Orders\OrderPlaced;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOrderSummaryToCustomer
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
     * @param  OrderPlaced  $event
     * @return void
     */
    public function handle(OrderPlaced $event)
    {
        //
    }
}
