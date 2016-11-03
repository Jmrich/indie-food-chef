<?php
/**
 * Created by PhpStorm.
 * User: jmrichardsonjr
 * Date: 8/28/16
 * Time: 11:04 AM
 */

namespace App\Services;


class CustomerService
{
    public function current()
    {
        return \Auth::user()->userable;
    }
}