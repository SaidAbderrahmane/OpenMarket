<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()) {
            if (Auth::user()->hasRole('Store owner'))
                return view('store_owner.index');
            else if (Auth::user()->hasRole('admin'))
                return redirect('/admin');
            else if (Auth::user()->hasRole('user'))
                return redirect('/products');
        }
        return redirect('/products');
    }
}
