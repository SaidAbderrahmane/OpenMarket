<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;

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
        if (request()->store) {
            $products = Product::with('store')->whereHas('store', function ($query) {
                $query->where('id', request()->store);
            })->orderBy($orderBy, $sort)->paginate(12);
        } else {
            $products = Product::with('store')->orderBy($orderBy, $sort)->paginate(12);
        }

        if (request()->category) {
            $products =  $products->toQuery()->with('categories')->whereHas('categories', function ($query) {
                $query->where('slug', request()->category)
                    ->orWhereIn('slug', function ($query) {
                        $query->from("categories")
                            ->select('slug')
                            ->where("parent_id", "=", function ($query) {
                                $query->from("categories")
                                    ->select("id")
                                    ->where("slug", "=", request()->category);
                            });
                    });
            })->orderBy($orderBy, $sort)->paginate(12);
        }

        //search
        if (request()->q) {
            $q = request()->input('q');

            $products =  $products->toQuery()->where('title', 'like', "%$q%")
                ->orWhere('description', 'like', "%$q%")
                ->orderBy($orderBy, $sort)
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

        $reviews = Review::where('product_id', $product->id)->get();
        $overall = $reviews->avg('rating');

        return view('products.detail', [
            'product' => $product,
            'products' => $products,
            'stock' => $stock,
            'reviews' => $reviews,
            'overall' => $overall,
        ]);
    }

    public function store(Request $request)
    {
        if (!empty($request->image)) {
            $newImageName = time() . '-' . $request->title . '.' . $request->image->extension();
            $request->image->move(public_path('storage'), $newImageName);
        }
        $product = Product::create(
            [
                'title' => $request->title,
                'slug' => $request->slug,
                'subtitle' => $request->subtitle,
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock,
                'store_id' => $request->store,
                'image' => $newImageName
            ]
        );

        $product->categories()->attach($request->categories);

        return redirect()->route('store_owner.products')->with('success', 'product added successfully');
    }

    public function update(Request $request, $id)
    {
        $product = Product::where('id', $id)->first();
        $newImageName = $product->image;
        if (!empty($request->image)) {
            $newImageName = time() . '-' . $request->title . '.' . $request->image->extension();
            $request->image->move(public_path('storage'), $newImageName);
            $product->update(
                [
                    'image' => $newImageName
                ]
            );
        }
        $product->update(
            [
                'title' => $request->title,
                'slug' => $request->slug,
                'subtitle' => $request->subtitle,
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock,
                'store_id' => $request->store
            ]
        );

        $product->categories()->sync($request->categories);

        return redirect()->route('store_owner.products')->with('success', 'product updated successfully');
    }

    public function destroy($id)
    {
        $product = Product::where('id', $id)->first();
        $product->delete();
        return redirect()->route('store_owner.products')->with('success', 'product removed successfully');
    }
}
