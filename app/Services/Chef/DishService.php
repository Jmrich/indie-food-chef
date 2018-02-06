<?php

namespace App\Services\Chef;


use App\Dish;
use Illuminate\Support\Facades\Storage;

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
     * @param bool $hasFile
     * @return Dish
     */
    public function update($dish, array $data, bool $hasFile = false)
    {
        if ($hasFile) {
            // get storage url
            $data['image_url'] = Storage::url($data['image_url']);
        }

        $data['price'] = (int) bcmul($data['price'], 100);

        $dish->update($data);

        return $dish;
    }
}