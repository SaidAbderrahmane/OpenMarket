@extends('layouts.app')
@section('content')
@include('layouts.modal')
<section class="py-5">
  <div class="container">
    <div class="row mb-5">
      <div class="col-lg-6">
        <!-- PRODUCT SLIDER-->
        <div class="row m-sm-0">
          <div class="col-sm-2 p-sm-0 order-2 order-sm-1 mt-2 mt-sm-0">
            <div class="owl-thumbs d-flex flex-row flex-sm-column" data-slider-id="1">
              <div class="owl-thumb-item flex-fill mb-2 mr-2 mr-sm-0"><img class="w-100" src="{{ asset('storage/'.$product->image) }}" alt="..."></div>
              @if ($product->images)
              @foreach (json_decode($product->images,true) as $image )
              <div class="owl-thumb-item flex-fill mb-2 mr-2 mr-sm-0"><img class="w-100" src="{{ asset('storage/'.$image) }}" alt="..."></div>
              @endforeach
              @endif
            </div>
          </div>
          <div class="col-sm-10 order-1 order-sm-2">
            <div class="owl-carousel product-slider" data-slider-id="1">
              <a class="d-block" href="{{ asset('storage/'.$product->image) }}" data-lightbox="product" title="Product item 1"><img class="img-fluid" src="{{ asset('storage/'.$product->image) }}" alt="..."></a>
              @if ($product->images)
              @foreach (json_decode($product->images,true) as $image )
              <a class="d-block" href="{{ asset('storage/'.$image) }}" data-lightbox="product" title="Product item 1"><img class="img-fluid" src="{{ asset('storage/'.$image) }}" alt="..."></a>
              @endforeach
              @endif
            </div>
          </div>
        </div>
      </div>
      <!-- PRODUCT DETAILS-->
      <div class="col-lg-6">
        <ul class="list-inline mb-2">
          <li class="list-inline-item m-0"><i class="fas fa-star small text-warning"></i></li>
          <li class="list-inline-item m-0"><i class="fas fa-star small text-warning"></i></li>
          <li class="list-inline-item m-0"><i class="fas fa-star small text-warning"></i></li>
          <li class="list-inline-item m-0"><i class="fas fa-star small text-warning"></i></li>
          <li class="list-inline-item m-0"><i class="fas fa-star small text-warning"></i></li>
        </ul>
        <h1>{{ $product->title }}</h1>
        <p class="text-muted lead">{{ $product->getPrice() }}</p>
        <p class="text-small mb-4">{{ $product->subtitle }}</p>
        @if ($stock === 'Available')
        <form action="{{ route('cart.store') }}" method="POST">
          @method('POST')
          @csrf
          <div class="row align-items-stretch mb-4">
            <div class="col-sm-4 pr-sm-0">
              <div class="border d-flex align-items-center justify-content-between py-1 px-3 bg-white border-white">
                <span class="small text-uppercase text-gray mr-4 no-select">Quantity</span>
                <div class="quantity">
                  <input name='qty' class="form-control form-control-md border-0 shadow-0 p-0" type="number" min="1" max="100" value="1">
                </div>
              </div>
            </div>
            <div class="col-sm-3 pl-sm-0">
              <input type="hidden" name="id" value="{{ $product->id }}">
              <button type="submit" class="btn btn-dark btn-sm btn-block h-100 d-flex align-items-center justify-content-center px-0">Add to cart</button>
            </div>
          </div>
        </form>
        @endif
        <form action="{{ route('wishlist.store') }}" method="POST">
          @csrf
          <input type="hidden" name="id" value="{{ $product->id }}">
          <button type="submit" class="btn btn-link text-dark p-0 mb-4"><i class="far fa-heart mr-2"></i>Add to wishlist</button>
        </form>
        <ul class="list-unstyled small d-inline-block">
          <li class="px-3 py-2 mb-1 bg-white text-muted"><strong class="text-uppercase text-dark">Categories:</strong>
            @foreach ( $product->categories as $category)
            <a class="reset-anchor ml-2" href="{{ route('shop',['category'=> $category->slug]) }}"> {{ $category->name}} {{ $loop->last ? '' : ', '}}</a>
            @endforeach
          </li>
          <li class="px-3 py-2 mb-1 bg-white text-muted"><strong class="text-uppercase text-dark">Tags:</strong><a class="reset-anchor ml-2" href="#">Innovation</a></li>
          <div class="badge badge-pill badge-info">{{ $stock }}</div>
        </ul>
      </div>
    </div>
    <!-- DETAILS TABS-->
    <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
      <li class="nav-item"><a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">Description</a></li>
      <li class="nav-item"><a class="nav-link" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Reviews</a></li>
    </ul>
    <div class="tab-content mb-5" id="myTabContent">
      <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
        <div class="p-4 p-lg-5 bg-white">
          <h6 class="text-uppercase">Product description </h6>
          <p class="text-muted text-small mb-0">{!! $product->description !!}</p>
        </div>
      </div>
      <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
        <div class="p-4 p-lg-5 bg-white">
          <div class="row">
            <div class="col-lg-8">
              <div class="media mb-3"><img class="rounded-circle" src="img/customer-1.png" alt="" width="50">
                <div class="media-body ml-3">
                  <h6 class="mb-0 text-uppercase">Jason Doe</h6>
                  <p class="small text-muted mb-0 text-uppercase">20 May 2020</p>
                  <ul class="list-inline mb-1 text-xs">
                    <li class="list-inline-item m-0"><i class="fas fa-star text-warning"></i></li>
                    <li class="list-inline-item m-0"><i class="fas fa-star text-warning"></i></li>
                    <li class="list-inline-item m-0"><i class="fas fa-star text-warning"></i></li>
                    <li class="list-inline-item m-0"><i class="fas fa-star text-warning"></i></li>
                    <li class="list-inline-item m-0"><i class="fas fa-star-half-alt text-warning"></i></li>
                  </ul>
                  <p class="text-small mb-0 text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                    do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>
              </div>
              <div class="media"><img class="rounded-circle" src="img/customer-2.png" alt="" width="50">
                <div class="media-body ml-3">
                  <h6 class="mb-0 text-uppercase">Jason Doe</h6>
                  <p class="small text-muted mb-0 text-uppercase">20 May 2020</p>
                  <ul class="list-inline mb-1 text-xs">
                    <li class="list-inline-item m-0"><i class="fas fa-star text-warning"></i></li>
                    <li class="list-inline-item m-0"><i class="fas fa-star text-warning"></i></li>
                    <li class="list-inline-item m-0"><i class="fas fa-star text-warning"></i></li>
                    <li class="list-inline-item m-0"><i class="fas fa-star text-warning"></i></li>
                    <li class="list-inline-item m-0"><i class="fas fa-star-half-alt text-warning"></i></li>
                  </ul>
                  <p class="text-small mb-0 text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                    do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- RELATED PRODUCTS-->
    <h2 class="h5 text-uppercase mb-4">Related products</h2>
    <div class="row">
      @foreach ($products as $product)
      @include('products.product')
      @endforeach
    </div>
  </div>
</section>
@include('layouts.jsFiles')
@endsection