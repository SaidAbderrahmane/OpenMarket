<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Cart::instance('wishlist');
        $wishlist = Wishlist::where('user_id', Auth::user()->id)->get();
        return view('wishlist.wishlist')->with(['wishlist' => $wishlist]);
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
        // Cart::instance('wishlist');
        // //duplication verification
        // $duplicate = Cart::search(function ($cartItem, $rowId)
        // use ($request) {
        //     return $cartItem->id == $request->id;
        // });
        // if ($duplicate->isNotEmpty()) {
        //     return redirect()->back()->with('success', 'The product has been already added to wishlist.');
        // }
        // $product = Product::find($request->id);
        // Cart::add($product->id, $product->title, 1, $product->price)
        //     ->associate('App\Models\Product');

        //duplication verification
        $duplicate = Wishlist::where('user_id', Auth::user()->id)->Where('product_id', $request->id)->first();

        if (!empty($duplicate)) {
            return redirect()->back()->with('success', 'The product has been already added to wishlist.');
        }
        $wishlist = new Wishlist();
        $wishlist->user_id = Auth::user()->id;
        $wishlist->product_id = $request->id;
        $wishlist->save();

        return redirect()->back()->with('success', 'The product has been added to wishlist successfully.');
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
        $wishlist = Wishlist::where('user_id', Auth::user()->id)->where('product_id', $id)->first();
        $wishlist->delete();

        // Cart::instance('wishlist');
        // Cart::remove($rowId);
        return back()->with('success', 'The item has been removed.');
    }
}
