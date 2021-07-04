@extends('layouts.app')
@section('content')

<!-- HERO SECTION-->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row px-4 px-lg-5 py-lg-4 justify-content-between">
            <div class="col-sm-4">
                <h1 class="h2 text-uppercase mb-0">Add store</h1>
            </div>
            <div class="col-sm-4 self-align-end text-lg-right ">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
                        <li class="breadcrumb-item"><a href="/products">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Stores</li>
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

                <a class="reset-anchor nav- link active" href="3">
                    <div class="py-2 px-4 bg-light mb-3"><strong class="small text-uppercase font-weight-bold">My stores </strong></div>
                </a>
                <a class="reset-anchor" href="{{ route('store_owner.products') }}">
                    <div class="py-2 px-4 bg-light mb-3"><strong class="small text-uppercase font-weight-bold">My products</strong></div>
                </a>
                <a class="reset-anchor nav- link active" href="#">
                    <div class="py-2 px-4 bg-light mb-3"><strong class="small text-uppercase font-weight-bold">Recieved Orders </strong></div>
                </a>

                <!-- <ul class="list-unstyled small text-muted pl-lg-4 font-weight-normal">
                    <li class="mb-2"><a class="reset-anchor" href="#">my orders</a></li>
                </ul> -->
            </div>
            <div class="col-lg-9 order-1 order-lg-2 mb-5 mb-lg-0">

            </div>

        </div>
    </div>
</section>
<section class="py-5">
    <form method="POST" action="{{ route('store.store') }}" enctype="multipart/form-data">
        @method('POST')
        @csrf

        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
            <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" required autofocus>
            </div>
        </div>
        <div class="form-group row">
            <label for="address" class="col-md-4 col-form-label text-md-right">address</label>
            <div class="col-md-6">
                <input id="address" type="text" class="form-control" name="address" required autofocus>
            </div>
        </div>
        <div class="form-group row">
            <label for="image" class="col-md-4 col-form-label text-md-right">Image</label>
            <div class="col-md-6">
                <div style="padding: 10px;">
                    <img id="image_display" src="" width="600" alt="">
                </div>
                <input id="image" name="image" type="file" class="file-control" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" autofocus>
            </div>
        </div>
        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    Create
                </button>
            </div>
        </div>
    </form>
</section>

@endsection
@section('extra-js')
@include('layouts.jsFiles')
@endsection