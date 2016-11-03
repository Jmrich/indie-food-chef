<?php

namespace App\Http\Controllers\Chef;

use App\Dish;
use App\Http\Requests\Chef\CreateMenuRequest;
use App\Menu;
use App\Section;
use App\Services\Chef\MenuService;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    public function __construct(MenuService $menuService)
    {
        $this->middleware('auth');
        $this->menuService = $menuService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::where('kitchen_id', getKitchen()->id)->orderBy('day_of_week')->get();

        return view('chef.menus.list', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('chef.menus.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateMenuRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMenuRequest $request)
    {
        $menu = $this->menuService->store($request->all());

        return redirect()->route('menus.show', [$menu])->with('message', 'Successfully created new menu');
    }

    /**
     * Display the specified resource.
     *
     * @param Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function show($menu)
    {
        $menu->load(['sections', 'sections.dishes']);

        return view('chef.menus.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function edit($menu)
    {
        $menu->load(['dishes']);

        $start = Carbon::today();

        $end = Carbon::today()->addDays(15);

        $interval = new DateInterval('P1D');

        $dates = collect(new DatePeriod($start, $interval, $end))->map(function ($date) {
            return $date->format("Y-m-d");
        });

        $dishes = Dish::where('kitchen_id', getChef()->kitchen->id)->get();

        return view('chef.menus.edit', compact('menu', 'dishes', 'dates'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $menu)
    {
        $this->menuService->update($menu, $request->all());

        return response()->json([
            'menu' => $menu->fresh('dishes'),
            'dishes' => $menu->dishes
        ]);
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
