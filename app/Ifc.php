<?php
/**
 * Created by PhpStorm.
 * User: jmrichardsonjr
 * Date: 8/28/16
 * Time: 11:32 AM
 */

namespace App;


class Ifc
{
    public static $commission = 10;

    public static function frontEndVariables()
    {
        if (! \Auth::check()) {
            return [];
        }

        return [
            'customer' => \Auth::user()->userable_type == 'customer' ? Ifc::currentCustomer() : null,
            'chef' => \Auth::user()->userable_type == 'chef' ? Ifc::currentChef() : null,
            'user' => \Auth::user(),
            'stripe_key' => env('STRIPE_KEY')
        ];
    }

    protected function currentUser()
    {

    }

    protected static function currentCustomer()
    {
        return \Auth::user()->userable;
    }

    protected static function currentChef()
    {
        return \Auth::user()->userable;
    }

    public static function isChef()
    {
        if (\Auth::check()) {
            return \Auth::user()->userable_type == 'chef';
        }
    }

    public static function isCustomer()
    {
        if (\Auth::check()) {
            return \Auth::user()->userable_type == 'customer';
        }
    }
}