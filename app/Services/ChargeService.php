<?php
/**
 * Created by PhpStorm.
 * User: jmrichardsonjr
 * Date: 8/27/16
 * Time: 10:22 AM
 */

namespace App\Services;


use App\Charge;
use App\Customer;
use App\Kitchen;
use App\Order;

class ChargeService
{
    protected $applicationFee;

    public function __construct(ApplicationFeeService $applicationFeeService)
    {
        $this->applicationFee = $applicationFeeService;
    }

    /**
     * Store the charge locally
     *
     * @param Customer $customer
     * @param \Stripe\Charge $charge
     */
    public function create($customer, $charge)
    {
        $local_charge = (new Charge)->forceFill([
            'id' => $charge->id,
            'amount' => $charge->amount,
            'amount_refunded' => $charge->amount_refunded,
            'captured' => $charge->captured,
            'application_fee' => $charge->application_fee,
            'source_id' => $charge->source['id'],
            'status' => $charge->status
        ]);

        // save the charge to the customer
        $customer->charges()->save($local_charge);
    }

    public function processCapturedCharge($billable, $kitchen, $order)
    {
        $charge = $billable->processCapturedCharge($order->charge_id, $kitchen);

        // update local charge with the application fee parameter
        Charge::where('id', $charge->id)->first()->forceFill([
            'application_fee' => $charge->application_fee,
            'captured' => 1
        ])->save();

        // calculate app fee for local storage
        $application_fee = new \Money\Money((int) $charge->amount, new \Money\Currency('USD'));

        $application_fee = $application_fee->multiply(10);

        $application_fee = $application_fee->divide(100);

        // Store the application fee
        $this->applicationFee->create([
            'id' => $charge->application_fee,
            'account' => '',
            'amount' => $application_fee->getAmount(),
            'amount_refunded' => 0,
            'charge_id' => $charge->id,
            'refunded' => 0
        ]);
    }

    /**
     * @param Customer $billable
     * @param Kitchen $kitchen
     * @param Order $order
     */
    public function cancelCapturedCharge($billable, $kitchen, $order)
    {
        $charge = $billable->refund($order->charge_id, $kitchen);

        // update charge to reflect the refund
    }
}