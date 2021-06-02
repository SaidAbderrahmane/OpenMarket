@extends('layouts.app')

@section('extra-meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<!-- HERO SECTION-->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
            <div class="col-lg-6">
                <div class="row">
                    <i class="fa fa-heart fa-2x mr-3"></i>
                    <h1 class="h2 text-uppercase mb-3">Wishlist</h1>
                </div>
            </div>
            <div class="col-lg-6 text-lg-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
                        <li class="breadcrumb-item"><a href="{{ route('shop') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
@if (Cart::count() > 0)

<section class="py-5">
    <h2 class="h5 text-uppercase mb-4">Wishlist</h2>
    <div class="row">
        <div class="col">
            <!-- CART TABLE-->
            <div class="table-responsive mb-4">
                <table class="table">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0" scope="col"> <strong class="text-small text-uppercase">Product</strong></th>
                            <th class="border-0" style="width: 12%;" scope="col"> <strong class="text-small text-uppercase">Subtitle</strong></th>
                            <th class="border-0" scope="col"> <strong class="text-small text-uppercase">Categories</strong></th>
                            <th class="border-0" style="width: 12%;" scope="col"> <strong class="text-small text-uppercase">Price</strong></th>
                            <th class="border-0" scope="col"></th>
                            <th class="border-0" scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (Cart::content() as $product)
                        <tr>
                            <th class="pl-0 border-0" scope="row">
                                <div class="media align-items-center"><a class="reset-anchor d-block animsition-link" href="/products/{{ $product->model->slug }}"><img src="{{ asset('storage/'.$product->model->image) }}" alt="..." width="70" /></a>
                                    <div class="media-body ml-3"><strong class="h6"><a class="reset-anchor animsition-link" href="/products/{{ $product->model->slug }}">{{ $product->model->title }}</a></strong></div>
                                </div>
                            </th>
                            <td class="align-middle border-0">
                                <p class="mb-0 small">{{ $product->model->subtitle }}</p>
                            </td>
                            <td class="align-middle border-0">
                                @foreach ($product->model->categories as $category)
                                <a class="reset-anchor mb-0 small" href="{{ route('shop',['category' => $category->slug]) }}">{{ $category->name }}</a>
                                @endforeach
                            </td>
                            <td class="align-middle border-0">
                                <p class="mb-0 small">{{ $product->model->getPrice() }}</p>
                            </td>
                            <td class="align-middle border-0">
                                <form action="{{ route('cart.store',['id'=>$product->model->id,'qty'=>1])}}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-outline-dark"><i class="fas fa-shopping-cart "></i> Add to cart</button>
                                </form>
                            </td>
                            <td class="align-middle border-0">
                                <form action="{{ route('wishlist.delete', $product->rowId) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="reset-anchor bg-transparent border-0"><i class="fas fa-trash-alt small text-muted"></i> Remove</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- CART NAV -->
            <div class="bg-light px-4 py-3">
                <div class="row align-items-center text-center">
                    <div class="col-md-6 mb-3 mb-md-0 text-md-left"><a class="btn btn-link p-0 text-dark btn-sm" href=" {{ route('shop') }} "><i class="fas fa-long-arrow-alt-left mr-2"> </i>Continue shopping</a></div>
                </div>
            </div>
        </div>
</section>

@else
<div class="alert alert-danger m-5">
    Your wishlist is empty.
</div>
@endif
</div>

@include('layouts.jsFiles')
@endsection