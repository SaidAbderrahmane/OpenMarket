<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Category;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;

class ProductsController extends Controller
{
    public function index()
    {
        if (request()->category) {
            $products = Product::with('categories')->whereHas('categories', function ($query) {
                $query->where('slug', request()->category)
                    ->orWhereIn('slug', function ($query) {
                        $query->from("categories")
                        ->select('slug')
                        ->where("parentid", "=", function ($query) {
                            $query->from("categories")
                                ->select("id")
                                ->where("slug", "=", request()->category);
                        });
                    });
            })->orderBy('created_at', 'DESC')->paginate(12);
        } else {
            $products = Product::with('categories')->orderBy('created_at', 'DESC')->paginate(12);
        }
        $categories = Category::all();
        return view('products.shop', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    public function details($slug)
    {
        $products = Product::all();
        $product = Product::where('slug', '=', $slug)->firstOrFail();
        $stock = $product->stock === 0 ? 'Unavailable' : 'Available';

        return view('products.detail', [
            'product' => $product,
            'products' => $products,
            'stock' => $stock
        ]);
    }

    public function search()
    {
        request()->validate([
            'q' => 'required|min:3'
        ]);

        $q = request()->input('q');

        $products = Product::where('title', 'like', "%$q%")
            ->orWhere('description', 'like', "%$q%")
            ->orderBy('created_at', 'DESC')
            ->paginate(12);

        $categories = Category::all();
        return view('products.shop', [
            'products' => $products,
            'categories' => $categories
        ]);
    }
}
