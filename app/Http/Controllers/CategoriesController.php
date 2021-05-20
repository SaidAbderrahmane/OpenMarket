<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Category::all();
        $test = Category::find(37);
         //dd($test->parent->name);

        return view('dashboard.categories', [
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.categories');
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
            'image' => 'required|mimes:png,jpg,jpeg|max:5048'
        ]);
        $newImageName = time() . '-' . $request->name . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $newImageName);

        $category = Category::create(
            [
                'name' => $request->input('name'),
                'parentid' => $request->input('parentid'),
                'image' => $newImageName
            ]
        );
        return redirect('dashboard/categories');
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
        return view('dashboard.categories');
        dd('$id');
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
        $request->validate([
            'name' => 'required',
            'image' => 'mimes:png,jpg,jpeg|max:5048'
        ]);
        $category = Category::where('id', $id);
        $newImageName = $category->first()->image;
        if(!empty($request->image)){
            $newImageName = time() . '-' . $request->name . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $newImageName);
        } 
        $category->update(
            [
                'name' => $request->input('name'),
                'parentid' => $request->input('parentid'),
                'image' => $newImageName 
            ]
        );
        return redirect('dashboard/categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $category = Category::where('id',$id)->first();
        $category->delete();
   
        return redirect('/dashboard/categories');
    }
}
