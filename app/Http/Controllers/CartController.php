<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cart.cart');
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
        $duplicate = Cart::search(function ($cartItem, $rowId)
        use ($request) {
            return $cartItem->id == $request->id;
        });
        if ($duplicate->isNotEmpty()) {
            return redirect()->route('shop')->with('success', 'The product has already been added.');
        }

        $product = Product::find($request->id);
        $stock = $product->stock;
        $validates = Validator::make($request->all(), [
            'qty' => 'numeric|required|min:1', //between:1,5
        ]);

        if ($validates->fails() || ($request->qty > $stock)) {
            if ($stock === 0) return back()->with('error', 'the product is currently not available');
            return back()->with('error', 'the quantity is not available');
        }
        Cart::add($product->id, $product->title, $request->qty, $product->price)
            ->associate('App\Models\Product');
        return redirect()->route('cart')->with('success', 'The product has been added.');
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
    public function update(Request $request, $rowId)
    {
        $data = $request->json()->all();
        $stock = Cart::get($rowId)->model->stock;
        $validates = Validator::make($request->all(), [
            'qty' => 'numeric|required|min:1', //between:1,5
        ]);

        if ($validates->fails() || ($request->qty > $stock)) {
            Session::flash('error', 'the required quantity is not available.');
            return response()->json(['error' => 'Cart quantity Has Not Been Updated']);
        }
        Cart::update($rowId,  $data['qty']);
        Session::flash('success', 'Cart quantity has been updated to ' . $data['qty'] . '.');
        return response()->json(['success' => 'Cart quantity has been updated']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($rowId)
    {
        Cart::remove($rowId);
        return back()->with('success', 'The item has been removed.');
    }
}
