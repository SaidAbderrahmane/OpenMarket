@extends('layouts.app')
@section('content')

<!-- HERO SECTION-->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row px-4 px-lg-5 py-lg-4 justify-content-between">
            <div class="col-sm-4">
                <h1 class="h2 text-uppercase mb-0">Add product</h1>
            </div>
            <div class="col-sm-4 self-align-end text-lg-right ">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
                        <li class="breadcrumb-item"><a href="/products">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Products</li>
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

                <a class="reset-anchor nav- link active" href="#">
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
    <form method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data">
        @method('POST')
        @csrf

        <div class="form-group row">
            <label for="title" class="col-md-4 col-form-label text-md-right">Title</label>
            <div class="col-md-6">
                <input id="title" type="text" class="form-control" name="title" required autofocus>
            </div>
        </div>
        <div class="form-group row">
            <label for="slug" class="col-md-4 col-form-label text-md-right">Slug</label>
            <div class="col-md-6">
                <input id="slug" type="text" class="form-control" name="slug" required autofocus>
            </div>
        </div>
        <div class="form-group row">
            <label for="subtitle" class="col-md-4 col-form-label text-md-right">Subtitle</label>
            <div class="col-md-6">
                <input id="subtitle" type="text" class="form-control" name="subtitle" required autofocus>
            </div>
        </div>
        <div class="form-group row">
            <label for="description" class="col-md-4 col-form-label text-md-right">Description</label>
            <div class="col-md-6">
                <textarea id="description" class="form-control" name="description" rows="15" required autofocus>

                </textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="price" class="col-md-4 col-form-label text-md-right">Price</label>
            <div class="col-md-6">
                <input id="price" type="number" class="form-control" name="price" required autofocus>
            </div>
        </div>
        <div class="form-group row">
            <label for="stock" class="col-md-4 col-form-label text-md-right">Stock</label>
            <div class="col-md-6">
                <input id="stock" type="number" class="form-control" name="stock" min="0" required autofocus>
            </div>
        </div>
        <div class="form-group row">
            <label for="store" class="col-md-4 col-form-label text-md-right">Store</label>
            <div class="col-md-6">
                <select name="store" class="form-control" id="store">
                    <option value=""></option>
                    @foreach ($stores as $store)
                    <option value="{{ $store->id }}">{{ $store->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="categories" class="col-md-4 col-form-label text-md-right">Category</label>
            <div class="col-md-6">
                <select name="categories[]" class="select form-control" id="categories" multiple size=3>
                    @foreach (App\Models\Category::all() as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="image" class="col-md-4 col-form-label text-md-right">Image</label>
            <div class="col-md-6">
                <div style="padding: 10px;">
                    <img id="image_display" src="" height="200" alt="">
                </div>
                <input id="image" name="image" type="file" class="file-control" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" autofocus>
            </div>
        </div>
        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    Save changes
                </button>
            </div>
        </div>
    </form>
</section>

@endsection
@section('extra-js')
@include('layouts.jsFiles')
@endsection