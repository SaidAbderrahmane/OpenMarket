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
        switch (request()->order) {

            case 'low-high':
                $orderBy = "price";
                $sort = "ASC";
                break;
            case 'high-low':
                $orderBy = "price";
                $sort = "DESC";
                break;
            default:
                $orderBy = "created_at";
                $sort = "DESC";
                break;
        }
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
            })->orderBy($orderBy, $sort)->paginate(12);
        } else {
            $products = Product::with('categories')->orderBy($orderBy, $sort)->paginate(12);
        }

        //search
        if (request()->q) {
            $q = request()->input('q');

            $products =  $products->toQuery()->where('title', 'like', "%$q%")
                ->orWhere('description', 'like', "%$q%")
                ->orderBy('created_at', 'DESC')
                ->paginate(12);
        }
        //price range filter
        if (request()->price_range) {
            $products =  $products->toQuery()->whereBetween('price', [json_decode(request()->price_range)[0] * 100, json_decode(request()->price_range)[1] * 100])
                ->orderBy($orderBy, $sort)->paginate(12);
        }
        // show only available items filter
        if (request()->available === 'true') {
            $products =  $products->toQuery()->where("stock", ">", 0)
                ->orderBy($orderBy, $sort)->paginate(12);
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

    // public function search()
    // {
    //     request()->validate([
    //         'q' => 'required|min:1'
    //     ]);

    //     $q = request()->input('q');

    //     $products = Product::where('title', 'like', "%$q%")
    //         ->orWhere('description', 'like', "%$q%")
    //         ->orderBy('created_at', 'DESC')
    //         ->paginate(12);

    //     $categories = Category::all();
    //     return view('products.shop', [
    //         'products' => $products,
    //         'categories' => $categories
    //     ]);
    // }
}
