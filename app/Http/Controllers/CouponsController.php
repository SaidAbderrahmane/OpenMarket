<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $code = $request->get('code');
        $coupon = Coupon::where('code', $code)->first();
        if (!$coupon) {
            return redirect()->back()->with('error', 'Coupon code is invalid.');
        }
        $request->session()->put('coupon', [
            'code' =>  $coupon->code,
            'discount' => $coupon->discount(Cart::subtotal()),
            'new_subtotal' => Cart::subtotal()-$coupon->discount(Cart::subtotal()),
            'new_tax' =>  (Cart::subtotal()-$coupon->discount(Cart::subtotal()))* config('cart.tax')/100,
            'new_total' => Cart::subtotal()-$coupon->discount(Cart::subtotal()) + (Cart::subtotal()-$coupon->discount(Cart::subtotal()))* config('cart.tax')/100
        ]);
        return redirect()->back()->with('success', 'Coupon code is valid.');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy()
    {
        request()->session()->forget('coupon');
        return redirect()->back()->with('success','The coupon has been removed with success');
    }

    public function CalculateCoupon()
    {
    }
}
