<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores = Store::all()->toQuery()->orderBy('created_at', 'DESC')->paginate(12);


        //search
        if (request()->q) {
            $q = request()->input('q');

            $stores =  $stores->toQuery()->where('name', 'like', "%$q%")
                ->orWhere('address', 'like', "%$q%")
                ->orderBy('created_at', 'DESC')
                ->paginate(12);
        }

        return view('stores.index', [
            'stores' => $stores
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
        $request->validate([
            'name' => 'required',
            'image' => 'required'
        ]);

        if (!empty($request->image)) {
            $newImageName = time() . '-' . $request->name . '.' . $request->image->extension();
            $request->image->move(public_path('storage'), $newImageName);
        }
        $store = Store::create(
            [
                'name' => $request->name,
                'address' => $request->address,
                'user_id' => Auth::user()->id,
                'image' => $newImageName
            ]
        );

        return redirect()->route('store_owner.stores')->with('success', 'store created successfully');
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
    public function update(Request $request, $id)
    {
        $store = Store::where('id', $id)->first();
        $newImageName = $store->image;
        if (!empty($request->image)) {
            $newImageName = time() . '-' . $request->name . '.' . $request->image->extension();
            $request->image->move(public_path('storage'), $newImageName);
            $store->update(
                [
                    'image' => $newImageName
                ]
            );
        }
        $store->update(
            [
                'name' => $request->name,
                'address' => $request->address,
                'user_id' => Auth::user()->id,
            ]
        );

        return redirect()->route('store_owner.stores')->with('success', 'store updated successfully');
    }

    public function destroy($id)
    {
        $store = Store::where('id', $id)->first();
        $store->delete();
        return redirect()->route('store_owner.stores')->with('success', 'store removed successfully');
    }
}
