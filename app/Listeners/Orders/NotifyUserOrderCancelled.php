<?php

namespace App\Listeners\Orders;

use App\Events\Orders\OrderCancelled;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyUserOrderCancelled
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
     * @param  OrderCancelled  $event
     * @return void
     */
    public function handle(OrderCancelled $event)
    {
        //
    }
}
