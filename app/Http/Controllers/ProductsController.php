<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('boutique.shop', [
            'products' => $products
        ]);
    }

    public function details($slug)
    {
        $products = Product::all();
        $product = Product::where('slug', '=', $slug)->firstOrFail();

        return view('boutique.detail', [
            'product' => $product ?? 'product ' . $slug . ' does not exist',
            'products' => $products
        ]);
    }
}
