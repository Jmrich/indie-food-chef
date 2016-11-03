<?php
/**
 * Created by PhpStorm.
 * User: jmrichardsonjr
 * Date: 8/27/16
 * Time: 1:14 PM
 */

namespace App\Services;


use App\ApplicationFee;

class ApplicationFeeService
{
    /**
     * Store the application fee
     *
     * @param array $data
     */
    public function create(array $data)
    {
        ApplicationFee::forceCreate($data);
    }
}