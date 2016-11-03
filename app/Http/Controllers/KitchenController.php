<?php

namespace App\Http\Controllers;

use App\Kitchen;
use App\Menu;
use Cache;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;

class KitchenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kitchens = Kitchen::all();

        return view('kitchen.list', compact('kitchens'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Kitchen $kitchen
     * @return \Illuminate\Http\Response
     */
    public function show(Kitchen $kitchen)
    {
        // load dishes for the current week only
        Carbon::setWeekStartsAt(0);

        Carbon::setWeekEndsAt(6);

        $menus = Menu::where('kitchen_id', $kitchen->id)->orderBy('day_of_week')->get();

        $menus->each(function ($menu) {
            $menu->load(['dishes' => function ($q) {
                $start_date = Carbon::today()->startOfWeek();

                $end_date = Carbon::today()->endOfWeek();

                return $q->where('end_date', '>=', $start_date)->where('start_date', '<=', $end_date);
            }]);

            $menu->dishes->transform(function ($dish) {
                $dish->setAttribute('quantity', 1);
                return $dish->setAttribute('notes', '');
            });
        });

        return view('kitchen.kitchen-show', compact('kitchen', 'menus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
