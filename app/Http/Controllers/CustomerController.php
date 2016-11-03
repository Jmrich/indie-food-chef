<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

use App\Http\Requests;

class CustomerController extends Controller
{
    /**
     * Get the current customer
     *
     * @return Customer
     */
    public function current()
    {
        if (\Auth::check()) {
            return \Auth::user()->userable_type == 'customer' ? \Auth::user()->userable : null;
        }
    }
}
