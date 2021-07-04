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
        <div class="row">
            <!--SIDEBAR-->
            <div class="col-lg-3 order-2 order-lg-1">

                <a class="reset-anchor nav- link active" href="{{ route('store_owner.stores') }}">
                    <div class="py-2 px-4 bg-light mb-3"><strong class="small text-uppercase font-weight-bold">My stores </strong></div>
                </a>
                <a class="reset-anchor" href="{{ route('store_owner.products') }}">
                    <div class="py-2 px-4 bg-light mb-3"><strong class="small text-uppercase font-weight-bold">My products</strong></div>
                </a>
                <a class="reset-anchor" href="{{ route('store_owner.orders') }}">
                    <div class="py-2 px-4 bg-light mb-3"><strong class="small text-uppercase font-weight-bold">Recieved Orders</strong></div>
                </a>
            </div>
            <div class="col-lg-9 order-1 order-lg-2 mb-5 mb-lg-0">
            </div>

        </div>
    </div>
</section>
@endsection
@section('extra-js')
@include('layouts.jsFiles')
@endsection