<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreOwnerController extends Controller
{
    public function index()
    {
        return view('store_owner.index');
    }

    public function products()
    {

        $stores_ids = [];
        $stores = Store::where('user_id', Auth::user()->id)->get();
        foreach ($stores as $store) {
            $stores_ids[] = $store->id;
        };
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
        $products = Product::whereIn('store_id', $stores_ids)->orderBy($orderBy, $sort)->paginate(15);

        //search
        if (request()->q) {
            $q = request()->input('q');

            $products =  $products->toQuery()->where('title', 'like', "%$q%")
                ->orWhere('description', 'like', "%$q%")
                ->orderBy($orderBy, $sort)->paginate(15);
        }
        if (request()->store) {
            $products =  $products->toQuery()->where('store_id', request()->store)
                ->orderBy($orderBy, $sort)->paginate(12);
        } else {
            $products = Product::with('store')->orderBy($orderBy, $sort)->paginate(12);
        }

        return view('store_owner.products')->with([
            'products' => $products,
            'stores' => $stores
        ]);
    }

    public function add_product()
    {
        $stores = Store::where('user_id', Auth::user()->id)->get();
        return view('store_owner.product-add')->with([
            'stores' => $stores
        ]);
    }

    public function edit_product($id)
    {
        $stores = Store::where('user_id', Auth::user()->id)->get();
        $product = Product::find($id);
        if ($product->store->user_id == Auth::user()->id) {
            return view('store_owner.product-edit')->with([
                'product' => $product,
                'stores' => $stores
            ]);
        } else return redirect()->back()->with('error', 'You do not have access to this url');
    }
    public function view_product($id)
    {
        $stores = Store::where('user_id', Auth::user()->id)->get();
        $product = Product::find($id);
        if ($product->store->user_id == Auth::user()->id) {
            return view('store_owner.product-view')->with([
                'product' => $product,
                'stores' => $stores
            ]);
        } else return redirect()->back()->with('error', 'You do not have access to this url');
    }

    // stores 

    public function stores()
    {

        $stores = Store::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(15);

        //search
        if (request()->q) {
            $q = request()->input('q');

            $stores =  $stores->toQuery()->where('name', 'like', "%$q%")
                ->orWhere('address', 'like', "%$q%")
                ->orderBy('created_at', 'DESC')->paginate(15);
        }

        return view('store_owner.stores')->with([
            'stores' => $stores
        ]);
    }


    public function add_store()
    {
        return view('store_owner.store-add');
    }

    public function edit_store($id)
    {
        $store = Store::find($id);
        if ($store->user_id == Auth::user()->id) {
            return view('store_owner.store-edit')->with([
                'store' => $store
            ]);
        } else return redirect()->back()->with('error', 'You do not have access to this url');
    }

    public function view_store($id)
    {
        $store = Store::find($id);
        if ($store->user_id == Auth::user()->id) {
            return view('store_owner.store-view')->with([
                'store' => $store
            ]);
        } else return redirect()->back()->with('error', 'You do not have access to this url');
    }
    public function orders()
    {
        $store_ids = [];
        foreach (Auth::user()->stores as $store) {
            $store_ids[] = $store->id;
        }
        $all_orders = Order::all();
        $order_ids = [];
        foreach ($all_orders as $order) {
            foreach ($order->orderLines as $orderline) {
                if (in_array($orderline->product->store->id, $store_ids)) {
                    $order_ids[] = $order->id;
                }
            }
        }
        $orders = Order::whereIn('id', $order_ids)->orderBy('created_at', 'DESC')->paginate(10);
        return view('store_owner.orders')->with([
            'orders' => $orders,
            'store_ids' => $store_ids
        ]);
    }

    public function update()
    {
        # code...
    }
}
