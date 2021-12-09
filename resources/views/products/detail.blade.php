@extends('layouts.app')
@section('content')
@include('layouts.modal')
<section class="py-5">
  <div class="container">
    <!-- Add Review Modal -->
    <div class="modal fade" id="addReview" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add a review</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="review_form_create" action="{{ route('review.store') }}" method="POST">
              @csrf
              @method('POST')
              <div class="form-group">
                <label for="rating">Rating (in a scale of 5 stars)</label> <br>
                <label for="rating_1">1 <i class="fas fa-star text-warning"></i></label>
                <input class="mr-4" type="radio" name="rating" value="1">
                <label for="rating_2">2 <i class="fa fa-star text-warning"></i></label>
                <input class="mr-4" type="radio" name="rating" value="2">
                <label for="rating_3">3 <i class="fa fa-star text-warning"></i></label>
                <input class="mr-4" type="radio" name="rating" value="3">
                <label for="rating_4">4 <i class="fa fa-star text-warning"></i></label>
                <input class="mr-4" type="radio" name="rating" value="4">
                <label for="rating_5">5 <i class="fa fa-star text-warning"></i></label>
                <input class="mr-4" type="radio" name="rating" value="5">
              </div>
              <div class="form-group">
                <label for="review_text">Review content</label>
                <textarea class="form-control" name="review_text" rows="3" placeholder="Tell us your opinion about this product"></textarea>
              </div>
              <input type="hidden" name="product_id" value="{{ $product->id }}">
            </form>
            <form id="review_form_update" action="" method="POST" hidden>
              @csrf
              @method('PATCH')
              <div class="form-group">
                <label for="rating">Rating (in a scale of 5 stars)</label> <br>
                <label for="rating_1">1 <i class="fas fa-star text-warning"></i></label>
                <input class="mr-4" type="radio" name="rating" id="rating_1" value="1">
                <label for="rating_2">2 <i class="fa fa-star text-warning"></i></label>
                <input class="mr-4" type="radio" name="rating" id="rating_2" value="2">
                <label for="rating_3">3 <i class="fa fa-star text-warning"></i></label>
                <input class="mr-4" type="radio" name="rating" id="rating_3" value="3">
                <label for="rating_4">4 <i class="fa fa-star text-warning"></i></label>
                <input class="mr-4" type="radio" name="rating" id="rating_4" value="4">
                <label for="rating_5">5 <i class="fa fa-star text-warning"></i></label>
                <input class="mr-4" type="radio" name="rating" id="rating_5" value="5">
              </div>
              <div class="form-group">
                <label for="review_text">Review content</label>
                <textarea class="form-control" id="review_text" name="review_text" rows="3" placeholder="Tell us your opinion about this product"></textarea>
              </div>
              <input type="hidden" name="product_id" value="{{ $product->id }}">
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-dark" id="create_review_btn" onclick="document.getElementById('review_form_create').submit();">Submit review</button>
            <button type="button" class="btn btn-dark" id="update_review_btn" onclick="document.getElementById('review_form_update').submit();" hidden>Save changes</button>
          </div>
        </div>
      </div>
    </div>
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
          @for ($i=1; $i<=$overall; $i++) <li class="list-inline-item m-0"><i class="fas fa-star small text-warning"></i></li>
            @endfor
            @if (floor( $overall ) != $overall)
            <li class="list-inline-item m-0"><i class="fas fa-star-half-alt small text-warning"></i></li>
            @endif
            @if ($overall)
            <label>({{ $overall}})</label>
            @endif
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
                  <input name='qty' class="form-control form-control-md border-0 shadow-0 p-0" type="number" min="1" max="{{ $product->stock }}" value="1">
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
          <li class="px-3 py-2 mb-1 bg-white text-muted"><strong class="text-uppercase text-dark">Store:</strong><a class="reset-anchor ml-2" href="{{ route('shop',['store' => $product->store->id]) }}">{{ $product->store->name }}</a></li>
          <li>
            <div class="badge badge-pill badge-info">{{ $stock }}
            </div>
          </li>
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
              @if ($reviews->count() == 0)
              <div class="alert alert-info">no reviews yet</div>
              @endif
              @foreach ($reviews as $review )
              <div class="media mb-3"><img class="rounded-circle" src="
                @if( !filter_var($review->user->avatar, FILTER_VALIDATE_URL)){{ Voyager::image( $review->user->avatar ) }}
                @else {{ $review->user->avatar }}@endif" alt="" width="50">
                <!-- <div class="media mb-3"><img class="rounded-circle" src="{{ asset('user_default.png') }}" alt="" width="50"> -->
                <div class="media-body ml-3">
                  <h6 class="mb-0 text-uppercase">{{ $review->user->name}}</h6>
                  <p class="small text-muted mb-0 text-uppercase">{{ $review->created_at}}</p>
                  <ul class="list-inline mb-1 text-xs">
                    <li class="list-inline-item">({{ $review->rating }})</li>
                    @for ($i=1; $i<=$review->rating; $i++) <li class="list-inline-item m-0"><i class="fas fa-star small text-warning"></i></li>
                      @endfor
                  </ul>
                  <p class="text-small mb-0 text-muted">{{ $review->review_text}}</p>
                </div>
                @if(Auth::user())
                @if ($review->user->id == Auth::user()->id || Auth::user()->role->name == 'admin')
                <div class="dropdown">
                  <button class="btn btn-transparent dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenu2">

                    <button class="dropdown-item" href="#" type="button" data-toggle="modal" data-target="#addReview" onclick="document.getElementById('review_text').value = '{{ $review->review_text }}';
                    document.getElementById('rating_{{$review->rating}}').checked = true;
                    document.getElementById('review_form_create').hidden = true; 
                    document.getElementById('create_review_btn').hidden = true; 
                    document.getElementById('review_form_update').hidden = false; 
                    document.getElementById('update_review_btn').hidden = false; 
                     document.getElementById('review_form_update').action = '/update-review/{{$review->id}}';">Edit</button>
                    <form action=" {{ route('review.destroy', $review->id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button class="dropdown-item" type="submit">Delete</button>
                    </form>
                  </div>
                </div>
                @endif
                @endif
              </div>
              @endforeach

            </div>
          </div>
          <div class="row">
            @if (Auth::user())
            <button type="button" class="btn btn-dark btn-md" data-toggle="modal" data-target="#addReview" onclick="document.getElementById('review_form_update').hidden = true; 
                    document.getElementById('update_review_btn').hidden = true;
                    document.getElementById('review_form_create').hidden = false; 
                    document.getElementById('create_review_btn').hidden = false;  ">add a review</button>
            @endif
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