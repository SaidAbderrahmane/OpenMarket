<?php

namespace App\Http\Controllers;

use DateTime;
use Gloudemans\Shoppingcart\Facades\Cart;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Charge;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\Product;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Cart::instance('shopping');

        if (Cart::count() <= 0) { //if the cart is empty
            return redirect()->route('shop');
        }
        Stripe::setApiKey('sk_test_51IuDBqFgbAj6W3MWKqTB7UzZXYjcRiRFgcEH3D8piflVmBcHkzw52wLq5QnqL76DSKdg9bclwEaJsxYCyFKzIbzg00ILtQBbNu');

        if (request()->session()->has('coupon')) {  //if a coupon is applied
            $total = request()->session()->get('coupon')['new_total'];
        } else {
            $total = Cart::total();
        }
        $intent = PaymentIntent::create([
            'amount' => round($total),
            'currency' => 'usd',
            'metadata' => [
                'userId' => Auth::user()->id
            ]
        ]);
        //Arr: an array helper of laravel 
        $clientSecret = Arr::get($intent, 'client_secret');
        return view('checkout.index', [
            'clientSecret' => $clientSecret
        ]);
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

        Cart::instance('shopping');
        if ($this->isNotAvailable()) {    //check if the ordered qty is still available
            $request->session()->flash('error', 'a product from your cart is not available anymore.');
            return response()->json(['success' => false], 400);
        }

        $data = $request->json()->all();
        $order = new Order();

        //order info 
        $order->name = $data['name'];
        $order->email = $data['email'];
        $order->phone = $data['phone'];
        $order->country = $data['country'];
        $order->city = $data['city'];
        $order->state = $data['state'];
        $order->line1 = $data['line1'];
        $order->line2 = $data['line2'];
        $order->postal_code = $data['postal_code'];
        $order->city = $data['city'];


        $order->payment_intent_id = $data['paymentIntent']['id'];
        $order->amount = $data['paymentIntent']['amount'];
        $order->payment_created_at = (new DateTime())
            ->setTimestamp($data['paymentIntent']['created'])
            ->format('Y-m-d H:i:s');
        $products = [];
        $i = 0;
        foreach (Cart::content() as $product) {
            $products['product_' . $i][] = $product->model->title;
            $products['product_' . $i][] = $product->model->price;
            $products['product_' . $i][] = $product->qty;
            $i++;
        }
        $order->products =  serialize($products);
        $order->user_id = Auth::user()->id;

        if ($data['paymentIntent']['status'] === 'succeeded') {
            $this->updateStock();
            $order->paid = true;
            $order->status = 'Pick up';
            $order->save();
            Cart::destroy();

            if (request()->session()->has('coupon')) {  //remove coupon if applied
                session()->forget('coupon');
            }
            Session::flash('success', 'Your order has been added successfully!');
            return response()->json(['success' => 'payment Intent Succeeded']);
        } else {
            return response()->json(['error' => 'Payment Intent Not succeeded']);
        }
    }

    public function thankyou()
    {
        return Session::has('success') ? view('checkout.thankyou') : redirect()->route('shop');
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
    public function destroy($id)
    {
        //
    }

    private function isNotAvailable()
    {
        Cart::instance('shopping');
        foreach (Cart::content() as $item) {
            $product = Product::find($item->model->id);

            if ($product->stock < $item->qty) {
                return true;
            }
        }
    }

    private function updateStock()
    {
        Cart::instance('shopping');
        foreach (Cart::content() as $item) {
            $product = Product::find($item->model->id);
            $product->update(['stock' => $product->stock - $item->qty]);
        }
    }
}
