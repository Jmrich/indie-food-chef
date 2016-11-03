<?php

namespace App\Http\Controllers;

use App\Chef;
use Illuminate\Http\Request;

use App\Http\Requests;

class ChefController extends Controller
{
    /**
     * Get the current customer
     *
     * @return Chef
     */
    public function current()
    {
        if (\Auth::check()) {
            return \Auth::user()->userable_type == 'chef' ? \Auth::user()->userable : null;
        }
    }
}
