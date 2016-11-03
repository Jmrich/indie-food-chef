<?php

namespace App\Http\Controllers\Chef;

use App\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function __construct(OrderService $orderService)
    {
        $this->middleware('auth');
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with('customer')->byKitchen()->get();

        /*$pending = $orders->reject(function ($order) {
            return $order->is_complete;
        });

        $completed = $orders->filter(function ($order) {
            return !$order->is_complete;
        });*/

        return view('chef.orders.list', compact('orders'));
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
     * @param  Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($order)
    {
        $order->load('customer');

        return view('chef.orders.show', compact('order'));
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

    public function complete($order)
    {
        $this->orderService->completeOrder($order);

        return redirect()->route('chef.orders.show', [$order])->with('message', 'Order has been successfully completed');
    }

    public function cancel($order)
    {
        //$this->orderService->cancelOrder($order);

        return redirect()->route('chef.orders.index')->with('message', 'Order has been successfully cancelled');
    }

    public function refund($order)
    {
        return redirect()->route('chef.orders.index')->with('message', 'Order has been successfully refunded');
    }
}
