<?php

namespace App\Http\Controllers\Orders;

use App\Dish;
use App\Exceptions\PaymentError;
use App\Http\Controllers\Controller;
use App\Kitchen;
use App\Order;
use App\Services\OrderService;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Money\Currency;
use Money\Money;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->middleware('auth');

        $this->orderService = $orderService;
    }

    /**
     * Display the order review for customer
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showOrderReview()
    {
        // If there is not a current order, return user to the home page
        // This page is reserved to review the order
        if (! $bag = session()->get('bag') ?? json_decode(Cookie::get('bag'), true)) {
            return redirect('/');
        }

        if (Auth::user()->userable == 'chef') {
            return redirect('/');
        }

        $kitchen  = Kitchen::find($bag['kitchen']['id']);

        // Load the users saved payment methods
        $customer = Auth::user()->userable->load(['paymentMethods', 'addresses']);

        return view('checkout.order-review', compact('bag', 'customer', 'kitchen'));
    }

    /**
     * Show order history for the customer
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = $request->user()->userable->orders()->simplePaginate(15);

        return view('orders.list', compact('orders'));
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
        // check if session has bag variable
        // which will determine if the
        // order was already placed
        if (! \Session::has('bag')) {
            return response()->json([
                'redirect' => route('orders.index')
            ]);
        }

        try {
            $order = \DB::transaction(function () use ($request) {
                return $this->orderService->create(\Auth::user()->userable, $request);
            });

            \Session::flash('message', 'Your order has successfully been placed. You will receive a confirmation once your order has been completed');

            return response()->json([
                'redirect' => route('orders.show', ['order' => $order->id])
            ]);
        } catch (PaymentError $e) {
            return response()->json([
                'payment_error' => [$e->getMessage()]
            ], 500);
        } catch (\Exception $e) {
            // some other error occurred
            return response()->json([
                'order_error' => [$e->getMessage()]
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($order)
    {
        //dd($order);
        if (! Auth::user()->ownsOrder($order)) {
            abort(404);
        }

        $order->load(['kitchen']);

        // Lets loop through and map a new collection
        // that has the dishes with the side dishes
        // for the order.

        $dishes = $order->dishes->map(function ($dish) {
            // lets return the dish along with the side dishes
            return [
                'main_dish' => $dish,
                'side_dish' => Dish::find($dish->pivot->side_dish_id) ?: ''
            ];
        });

        return view('orders.show', compact('order', 'dishes'));
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
