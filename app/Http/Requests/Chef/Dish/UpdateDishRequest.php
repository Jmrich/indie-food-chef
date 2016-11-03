<?php

namespace App\Http\Requests\Chef\Dish;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDishRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $dish = $this->route('dish');

        return getKitchen()->id == $dish->kitchen_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'price' => 'numeric',
            'extra_cost' => 'numeric',
            'is_archived' => 'required'
        ];
    }
}
