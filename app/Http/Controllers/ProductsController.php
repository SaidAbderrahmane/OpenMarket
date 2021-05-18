<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;

class ProductsController extends Controller
{
    public function index(){

        $data = Categories::all();

        return view('welcome',[
            'data' => $data
        ]);
    }

    public function details($name){
        $data = [
            'iphone' => 'Iphone XR',
            'huawei' => 'Huawei p50 pro'
        ];
        return view('products.details',[
            'product' => $data[$name] ?? 'product '.$name.' does not exist'
        ]);
    }
}
