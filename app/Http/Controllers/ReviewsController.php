<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        // dd(Auth::user()->id,$request->input('product_id'));
        $request->validate([
            'rating' => 'required|min:1|max:5',
            'review_text' => 'required'
        ]);

        $review = Review::create(
            [
                'user_id' => Auth::user()->id,
                'product_id' => $request->input('product_id'),
                'rating' => $request->input('rating'),
                'review_text' => $request->input('review_text'),
            ]
        );

        return redirect()->back()->with('success', 'Thank you for your feedback!');
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
        $request->validate([
            'rating' => 'required|min:1|max:5',
            'review_text' => 'required'
        ]);
        $review = Review::where('id', $id);
        $review->update([
            'rating' => $request->input('rating'),
            'review_text' => $request->input('review_text'),
        ]);
        return redirect()->back()->with('success', 'Review updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $review = Review::where('id', $id)->first();
        if (Auth::user()->id == $review->user->id || Auth::user()->role->name == 'admin') {
            $review->delete();
        } else {
            return redirect()->back()->with('error', 'You don\'t have the right for this action!');
        }
        return redirect()->back()->with('success', 'Review deleted successfully.');
    }
}
