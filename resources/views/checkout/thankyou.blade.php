@extends('layouts.app')

@section('content')
<div class="container">
@if (session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
    <!-- HERO SECTION-->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                <div class="col-lg-6">
                    <h1 class="h2 text-uppercase mb-0">Thank you</h1>
                </div>
                <div class="col-lg-6 text-lg-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
                            <li class="breadcrumb-item"><a href="{{ route('shop') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('cart') }}">Cart</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                            <li class="breadcrumb-item active" aria-current="page">Thanks</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- Thanks Message -->
    <section class="py-5">
        <div class="container">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                <div class="col-lg-6">
                    <div >
                        <h1 class="h4 font-weight-light font-italic mb-0">Your order has been added successfully !</h1>
                    </div>
                </div>
            </div>
            <!-- CART NAV -->
            <div class="px-4 py-3">
                <div class="row align-items-center text-center">
                    <div class="col-md-6 mb-3 mb-md-0 text-md-left"><a class="btn btn-link p-0 text-dark btn-sm" href=" {{ route('shop') }} "><i class="fas fa-long-arrow-alt-left mr-2"> </i>Continue shopping</a></div>
                </div>
            </div>
        </div>
    </section>
    @include('layouts.jsFiles')
</div>

@endsection