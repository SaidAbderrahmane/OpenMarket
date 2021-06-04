@extends('layouts.app')
@section('content')
@include('layouts.modal')

<!-- HERO SECTION-->
<section class="py-5 bg-light">
  <div class="container">
    <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
      <div class="col-lg-6">
        <h1 class="h2 text-uppercase mb-0">Shop</h1>
      </div>
      <div class="col-lg-6 text-lg-right">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Shop</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>
<section class="py-5">
  <div class="container p-0">
    <div class="row">
      <!-- SHOP SIDEBAR-->
      <div class="col-lg-3 order-2 order-lg-1">
        <h5 class="text-uppercase mb-4">Categories</h5>
        @foreach ($categories as $category)
        @if ($category->parent === null)
        <a class="reset-anchor" href="{{ route('shop',['category' => $category->slug]) }}">
          <div class="py-2 px-4 bg-dark text-white mb-3"><strong class="small text-uppercase font-weight-bold">{{ $category->name }}</strong></div>
        </a>
        @endif
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
        <div class="row justify-content-center">
          <a id="apply_range" class="btn btn-dark text-white mb-4">apply</a>
        </div>

        <h6 class="text-uppercase mb-3">Show only</h6>
        <div class="custom-control custom-checkbox mb-4">
          <input class="custom-control-input" id="available" type="checkbox">
          <label class="custom-control-label text-small" for="available">Available items</label>
        </div>
        <!-- <h6 class="text-uppercase mb-3">Buying format</h6>
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
        </div> -->
      </div>
      <!-- SHOP LISTING-->
      <div class="col-lg-9 order-1 order-lg-2 mb-5 mb-lg-0">
        <div class="row mb-3 align-items-center">
          <div class="col-sm-3 mb-2 mb-lg-0">
            @if (request()->input('q'))
            <p class="text-small text-muted mb-0">Showing 1–{{ $products->total()>=12 ? 12 : $products->total() }} of {{ $products->total() }} of: {{ request()->q }}</p>
            @else
            <p class="text-small text-muted mb-0">Showing 1–{{ $products->total()>=12 ? 12 : $products->total() }} of {{ $products->total() }} results</p>
            @endif
          </div>
          <div class="col-sm-5">
            <form class="form-inline my-2 my-lg-0" action="{{ route('shop') }}">
              <input class="form-control mr-sm-2" type="search" name="q" value="{{ request()->q ?? ''}}" placeholder="Search" aria-label="Search" required>
              <button class="btn btn-dark reset-anchor" type="submit"><i class="fas fa-search"></i></button>
            </form>
          </div>
          <div class="col-sm-4">
            <ul class="list-inline d-flex align-items-center justify-content-lg-end mb-0">
              <!-- <li class="list-inline-item text-muted mr-3"><a class="reset-anchor p-0" href="{{ route('shop',['order'=>'low-high']) }}">Price: Low to High</a></li> -->
              <!--  <li class="list-inline-item text-muted mr-3"><a class="reset-anchor p-0" href="#"><i class="fas fa-th"></i></a></li> -->
              <li class="list-inline-item">
                <select class="selectpicker ml-auto" id="sorting" name="sorting" data-width="200" data-style="bs-select-form-control" data-title="Default sorting">
                  <option value="date" selected>Date</option>
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
          <!-- in case of no results -->
        </div>
        @if($products->total()===0)
        <div class="alert alert-info">no results to show</div>
        @endif
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
@endsection
@section('extra-js')
@include('layouts.jsFiles')
<!-- Nouislider Config-->
<script>
  var sortBy = document.getElementById('sorting')
  sortBy.addEventListener('change', sortedBy, false);

  function sortedBy() {
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.set('order', sortBy.value);
    window.location.search = urlParams;
  }
</script>
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
        return value;
      },
      from: function(value) {
        return value.replace('', '');
      }
    }
  });

  const urlParams = new URLSearchParams(window.location.search);
  //initiaize filters values
  range.noUiSlider.set(JSON.parse(urlParams.get('price_range')));
  available = document.getElementById('available');
  available.checked = urlParams.get('available') == 'true';
  var apply_range = document.getElementById('apply_range');
  apply_range.addEventListener('click', applyRange, false);
  available.addEventListener('change', applyShowOnly, false);

  //apply filters

  //price range
  function applyRange() {
    urlParams.set('price_range', JSON.stringify(range.noUiSlider.get()));
    //console.log(JSON.stringify(range.noUiSlider.get()), available.value);
    window.location.search = urlParams;
  }
  //show only
  function applyShowOnly() {
    urlParams.set('available', available.checked);
    window.location.search = urlParams;
  }
</script>
@endsection