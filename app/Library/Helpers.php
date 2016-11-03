<?php
use App\Chef;

/**
 * Perform the math operations and return the float value
 *
 * @param $number1
 * @param $number2
 * @param string $operation
 * @return float
 */
function priceCalculation($number1, $number2, $operation = '+')
{
    $value = 0;

    switch ($operation)
    {
        case '*':
            $value = $number1 * $number2;
            break;
        case '/':
            $value = $number2 == 0 ? $number1/$number2 : 0;
            break;
        case '-':
            $value = $number1 - $number2;
            break;
        default:
            $value = $number1 + $number2;
    }

    return roundValue($value);
}

/**
 * Round the value to hundredths
 *
 * @param $value
 * @return float
 */
function roundValue($value)
{
    return round($value, 2);
}

/**
 * Converts decimal/string to integer for stripe charge
 *
 * @param $value
 * @return int
 */
function formatForStripe($value)
{
    if (is_int($value)) {
        return $value;
    }

    return (int) round($value);
}

function userIsAChef()
{
    return Auth::check() ? Auth::user()->userable_type == 'chef' : false;
}

function userIsACustomer()
{
    return Auth::check() ? Auth::user()->userable_type == 'customer' : false;
}

/**
 * Get the chef instance
 *
 * @return Chef|null
 */
function getChef()
{
    return Auth::check() ? Auth::user()->userable : null;
}

function getKitchen()
{
    return is_null($chef = getChef()) ?: $chef->kitchen;
}
