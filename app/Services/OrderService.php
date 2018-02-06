<?php
/**
 * Created by PhpStorm.
 * User: jmrichardsonjr
 * Date: 8/19/16
 * Time: 10:49 AM
 */

namespace App\Services;


use App\Customer;
use App\Dish;
use App\Events\Orders\OrderCancelled;
use App\Events\Orders\OrderFulfilled;
use App\Events\OrderWasCompleted;
use App\Exceptions\PaymentError;
use App\Kitchen;
use App\Order;
use Illuminate\Http\Request;
use Money\Money;

class OrderService
{
    protected $paymentService;

    protected $chargeService;

    public function __construct(PaymentService $paymentService, ChargeService $chargeService)
    {
        $this->paymentService = $paymentService;

        $this->chargeService = $chargeService;
    }

    public function create(Customer $customer, $request)
    {
        // Get the kitchen
        $kitchen = Kitchen::find($request->bag['kitchen']['id']);

        if (! \Session::has('order_id')) {
            $order = $this->createOrder($customer, $request);
        } else {
            $order = Order::find(\Session::get('order_id'));
        }

        // Charge the customer, if successful store order
        // else return with error
        $charge = $this->paymentService->charge($customer, $kitchen, $request->bag['total']);
        /*try {
            $charge = $this->paymentService->charge($customer, $kitchen, $request->bag['total']);
        } catch (PaymentError $e) {
            throw new PaymentError($e->getMessage());
        }*/

        // Mark order as complete, and save
        $order->forceFill([
            'charge_id' => $charge->id
        ])->save();

        // Store the charge locally
        $this->chargeService->create($customer, $charge);

        // Forget the order id from the session
        \Session::forget('order_id');

        // Forget the bag from the session
        \Session::forget('bag');

        // Fire event to alert chef/kitchen/user that an order was placed
        //event(new OrderPlaced($order->fresh(['kitchen']), \Auth::user()));

        return $order;
    }

    protected function createOrder($customer, $data)
    {
        // First lets make the order items a collection
        $dishes = collect($data->bag['items']);

        // Now lets get the subtotal of the items
        $subtotal = $data->bag['subtotal'];

        // Figure out the tax
        $tax = $data->bag['tax'];

        // Calculate total
        $total = $data->bag['total'];

        // Save the order
        $order = Order::forceCreate([
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'kitchen_id' => $data->bag['kitchen']['id'],
            'customer_id' => $customer->id,
            'delivery' => $data->bag['pickupOrDelivery'] == 'delivery' ? true : false,
            'delivery_fee' => $data->bag['deliveryFeeSet'] ? 500 : null,
            'delivery_address' => $data->bag['pickupOrDelivery'] == 'delivery' ? $data['deliveryAddress'] : null,
        ]);

        $dishes->each(function ($dish) use ($order) {
            // Save dishes to the order, include side dish for the main dish
            $order->dishes()->save(Dish::findOrFail($dish['id']), [
                'notes' => $dish['notes'],
                'quantity' => $dish['quantity'],
                /*'side_dish_id' => $dish['side_dish']['id'] ?? '',
                'main_dish_notes' => $dish['main_dish_notes'] ?? '',
                'side_dish_notes' => $dish['side_dish_notes'] ?? ''*/
            ]);
        });

        // Store the order id so we can reference it
        // and show that the order is already
        // in the database
        \Session::put('order_id', $order->id);

        return $order;
    }

    /**
     * Complete the order
     *
     * @param Order $order
     * @return bool
     */
    public function completeOrder($order)
    {
        // process payment
        $this->chargeService->processCapturedCharge($order->customer, $order->kitchen, $order);

        event(new OrderFulfilled($order));

        // mark order as complete
        return $order->forceFill(['is_complete' => 1])->save();
    }

    /**
     * @param Order $order
     */
    public function cancelOrder($order)
    {
        // cancel payment
        $this->chargeService->cancelCapturedCharge($order->customer, $order->kitchen, $order);

        // remove order from system????
        $order->forceFill(['is_cancelled' => 1])->save();

        event(new OrderCancelled($order));
    }
}