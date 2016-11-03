<?php
/**
 * Created by PhpStorm.
 * User: jmrichardsonjr
 * Date: 8/20/16
 * Time: 12:45 PM
 */

namespace App\Services;


use App\Exceptions\PaymentError;
use Stripe\Charge;
use Stripe\Error\Card;
use Stripe\Stripe;

class PaymentService
{
    /**
     * @param $billable
     * @param $kitchen
     * @param integer $amount
     * @return Charge
     * @throws PaymentError
     */
    public function charge($billable, $kitchen, $amount)
    {
        try {
            // Attempt to charge the customer
            return $billable->charge($amount, $kitchen);
        } catch (Card $e) {
            // card was declined
            throw new PaymentError($e->getMessage());
        }
    }
}