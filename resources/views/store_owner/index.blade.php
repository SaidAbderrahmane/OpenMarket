@extends('layouts.app')
@section('content')

<!-- HERO SECTION-->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row px-4 px-lg-5 py-lg-4 justify-content-between">
            <div class="col-sm-4">
                <h1 class="h2 text-uppercase mb-0">Store Owner Dashboard</h1>
            </div>
            <div class="col-sm-4 self-align-end text-lg-right ">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
                        <li class="breadcrumb-item"><a href="/products">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Store Owner Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    </div>
</section>
<section class="py-5">
    <div class="container p-0">
        <div class="row justify-content-center">
            <!--SIDEBAR-->
            <!-- <div class="col-lg-3">

                <a class="reset-anchor nav- link active" href="{{ route('store_owner.stores') }}">
                    <div class="py-2 px-4 bg-light mb-3"><strong class="small text-uppercase font-weight-bold">My stores </strong></div>
                </a>

                <a class="reset-anchor" href="{{ route('store_owner.products') }}">
                    <div class="py-2 px-4 bg-light mb-3"><strong class="small text-uppercase font-weight-bold">My products</strong></div>
                </a>
                <a class="reset-anchor" href="{{ route('store_owner.orders') }}">
                    <div class="py-2 px-4 bg-light mb-3"><strong class="small text-uppercase font-weight-bold">Recieved Orders</strong></div>
                </a>
            </div> -->
            <div class="col-lg-3 m-3">
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="{{ asset('storage/products-widget.jpg') }}" height="300px" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">My stores</h5>
                        <p class="card-text">You have {{ App\Models\Store::where('user_id',Auth::user()->id)->count() }} stores.</p>
                        <a href="{{ route('store_owner.stores') }}" class="btn btn-primary">My stores</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 m-3">
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="{{ asset('storage/cart-widget.jpg') }}" height="300px" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">My products</h5>
                        <p class="card-text">You have {{ App\Models\Product::whereIn('store_id',App\Models\Store::select('id')->where('user_id',Auth::user()->id))->count() }} products.</p>
                        <a href="{{ route('store_owner.products') }}" class="btn btn-primary">My products</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 m-3">
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="{{ asset('storage/orders-widget.jpg') }}" height="300px" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Recieved orders</h5>
                        <p class="card-text">See your recieved orders.</p>
                        <a href="{{ route('store_owner.orders') }}" class="btn btn-primary">Recieved orders</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
@section('extra-js')
@include('layouts.jsFiles')
@endsection