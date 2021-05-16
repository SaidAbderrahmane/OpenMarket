<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(){
        $title="welcome to my world!!";
        $data = [
            'productOne' => 'Huawei',
            'productkda' => 'Poco'
        ];

        return view('products.index',compact('data'));
    }

    public function about() {
        return 'about us page or whatever!';
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
