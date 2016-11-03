<?php

namespace App\Services\Chef;


use App\Dish;

class DishService
{
    /**
     * Handle storing the dish
     *
     * @param array $data
     * @return Dish
     */
    public function store(array $data)
    {
        $data['price'] = (int) bcmul($data['price'], 100);

        return getKitchen()->dishes()->save(new Dish($data));
    }

    /**
     * Handle updating the dish
     *
     * @param Dish $dish
     * @param array $data
     *
     * @return Dish
     */
    public function update($dish, array $data)
    {
        $data['price'] = (int) bcmul($data['price'], 100);

        $dish->update($data);

        return $dish;
    }
}