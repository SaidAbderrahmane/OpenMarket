<?php

namespace App\Listeners;

use App\Models\Coupon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CartUpdatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $code = request()->session()->get('coupon');

        $coupon = Coupon::where('code', $code)->first();

        if ($coupon) {
            request()->session()->put('coupon', [
                'code' =>  $coupon->code,
                'discount' => $coupon->discount(Cart::subtotal()),
                'new_subtotal' => Cart::subtotal() - $coupon->discount(Cart::subtotal()),
                'new_tax' => (Cart::subtotal() - $coupon->discount(Cart::subtotal())) * config('cart.tax') / 100,
                'new_total' => Cart::subtotal() - $coupon->discount(Cart::subtotal()) + (Cart::subtotal() - $coupon->discount(Cart::subtotal())) * config('cart.tax') / 100
            ]);
        }
    }
}
