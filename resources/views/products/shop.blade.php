@extends('layouts.app')
@section('content')
@include('layouts.modal')

<div class="container">
  @if (session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  @include('layouts.heroSection')
  <section class="py-5">
    <div class="container p-0">
      <div class="row">
        <!-- SHOP SIDEBAR-->
        <div class="col-lg-3 order-2 order-lg-1">
          <h5 class="text-uppercase mb-4">Categories</h5>
          @foreach ($categories as $category)
          <a class="reset-anchor" href="{{ route('shop',['category' => $category->slug]) }}">
          <div class="py-2 px-4 bg-dark text-white mb-3"><strong class="small text-uppercase font-weight-bold">{{ $category->name }}</strong></div></a>
          <ul class="list-unstyled small text-muted pl-lg-4 font-weight-normal">
            @foreach ($category->subcategories as $subcategory)
            <li class="mb-2"><a class="reset-anchor" href="{{ route('shop',['category' => $subcategory->slug]) }}">{{ $subcategory->name }}</a></li>
            @endforeach
          </ul>
          @endforeach
          <h6 class="text-uppercase mb-4">Price range</h6>
          <div class="price-range pt-4 mb-5">
            <div id="range"></div>
            <div class="row pt-2">
              <div class="col-6"><strong class="small font-weight-bold text-uppercase">From</strong></div>
              <div class="col-6 text-right"><strong class="small font-weight-bold text-uppercase">To</strong></div>
            </div>
          </div>
          <h6 class="text-uppercase mb-3">Show only</h6>
          <div class="custom-control custom-checkbox mb-1">
            <input class="custom-control-input" id="customCheck1" type="checkbox">
            <label class="custom-control-label text-small" for="customCheck1">Returns Accepted</label>
          </div>
          <div class="custom-control custom-checkbox mb-1">
            <input class="custom-control-input" id="customCheck2" type="checkbox">
            <label class="custom-control-label text-small" for="customCheck2">Returns Accepted</label>
          </div>
          <div class="custom-control custom-checkbox mb-1">
            <input class="custom-control-input" id="customCheck3" type="checkbox">
            <label class="custom-control-label text-small" for="customCheck3">Completed Items</label>
          </div>
          <div class="custom-control custom-checkbox mb-1">
            <input class="custom-control-input" id="customCheck4" type="checkbox">
            <label class="custom-control-label text-small" for="customCheck4">Sold Items</label>
          </div>
          <div class="custom-control custom-checkbox mb-1">
            <input class="custom-control-input" id="customCheck5" type="checkbox">
            <label class="custom-control-label text-small" for="customCheck5">Deals &amp; Savings</label>
          </div>
          <div class="custom-control custom-checkbox mb-4">
            <input class="custom-control-input" id="customCheck6" type="checkbox">
            <label class="custom-control-label text-small" for="customCheck6">Authorized Seller</label>
          </div>
          <h6 class="text-uppercase mb-3">Buying format</h6>
          <div class="custom-control custom-radio">
            <input class="custom-control-input" id="customRadio1" type="radio" name="customRadio">
            <label class="custom-control-label text-small" for="customRadio1">All Listings</label>
          </div>
          <div class="custom-control custom-radio">
            <input class="custom-control-input" id="customRadio2" type="radio" name="customRadio">
            <label class="custom-control-label text-small" for="customRadio2">Best Offer</label>
          </div>
          <div class="custom-control custom-radio">
            <input class="custom-control-input" id="customRadio3" type="radio" name="customRadio">
            <label class="custom-control-label text-small" for="customRadio3">Auction</label>
          </div>
          <div class="custom-control custom-radio">
            <input class="custom-control-input" id="customRadio4" type="radio" name="customRadio">
            <label class="custom-control-label text-small" for="customRadio4">Buy It Now</label>
          </div>
        </div>
        <!-- SHOP LISTING-->
        <div class="col-lg-9 order-1 order-lg-2 mb-5 mb-lg-0">
          <div class="row mb-3 align-items-center">
            <div class="col-lg-6 mb-2 mb-lg-0">
              <p class="text-small text-muted mb-0">Showing 1–12 of 53 results</p>
            </div>
            <div class="col-lg-6">
              <ul class="list-inline d-flex align-items-center justify-content-lg-end mb-0">
                <li class="list-inline-item text-muted mr-3"><a class="reset-anchor p-0" href="#"><i class="fas fa-th-large"></i></a></li>
                <li class="list-inline-item text-muted mr-3"><a class="reset-anchor p-0" href="#"><i class="fas fa-th"></i></a></li>
                <li class="list-inline-item">
                  <select class="selectpicker ml-auto" name="sorting" data-width="200" data-style="bs-select-form-control" data-title="Default sorting">
                    <option value="default">Default sorting</option>
                    <option value="popularity">Popularity</option>
                    <option value="low-high">Price: Low to High</option>
                    <option value="high-low">Price: High to Low</option>
                  </select>
                </li>
              </ul>
            </div>
          </div>
          <div class="row">
            @foreach ($products as $product)
            @include('products.product')
            @endforeach
          </div>
          <!-- PAGINATION-->
          {{ $products->appends(request()->input())->links()}}
          <!-- <nav aria-label="Page navigation example">
              <ul class="pagination justify-content-center justify-content-lg-end">
                <li class="page-item"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
              </ul>
            </nav> -->

        </div>
      </div>
  </section>
</div>
@include('layouts.jsFiles')
@endsection
@section('extra-js')
<!-- Nouislider Config-->
<script>
  var range = document.getElementById('range');
  noUiSlider.create(range, {
    range: {
      'min': 0,
      'max': 2000
    },
    step: 5,
    start: [100, 1000],
    margin: 300,
    connect: true,
    direction: 'ltr',
    orientation: 'horizontal',
    behaviour: 'tap-drag',
    tooltips: true,
    format: {
      to: function(value) {
        return '$' + value;
      },
      from: function(value) {
        return value.replace('', '');
      }
    }
  });
</script>
@endsection