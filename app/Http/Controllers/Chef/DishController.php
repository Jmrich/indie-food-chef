<?php

namespace App\Http\Controllers\Chef;

use App\Dish;
use App\Http\Requests\Chef\Dish\CreateDishRequest;
use App\Http\Requests\Chef\Dish\UpdateDishRequest;
use App\Services\Chef\DishService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DishController extends Controller
{
    public function __construct(DishService $dishService)
    {
        $this->middleware('auth');

        $this->dishService = $dishService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dishes = Dish::where('kitchen_id', getChef()->kitchen->id)->orderBy('name')->get();

        return view('chef.dishes.list', compact('dishes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('chef.dishes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateDishRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateDishRequest $request)
    {
        $dish = $this->dishService->store($request->all());

        return redirect()->route('dishes.show', [$dish])->with('message', 'Successfully created the new dish');
    }

    /**
     * Display the specified resource.
     *
     * @param  Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function show($dish)
    {
        return view('chef.dishes.show', compact('dish'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function edit($dish)
    {
        return view('chef.dishes.edit', compact('dish'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDishRequest $request
     * @param  Dish $dish
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDishRequest $request, $dish)
    {
        if ($this->dishService->update($dish, $request->all())) {
            return redirect()->route('dishes.show', [$dish])->with('message', 'Successfully updated!');
        }

        return redirect()->back()->with('message', 'An error occurred while updating. Please try again.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
