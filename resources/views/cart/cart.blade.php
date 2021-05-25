@extends('layouts.app')

@section('extra-meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

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
  @if (session('error'))
  <div class="alert alert-danger">
    {{ session('error') }}
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
          <h1 class="h2 text-uppercase mb-0">Cart</h1>
        </div>
        <div class="col-lg-6 text-lg-right">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
              <li class="breadcrumb-item"><a href="{{ route('shop') }}">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Cart</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </section>
  @if (Cart::count() > 0)

  <section class="py-5">
    <h2 class="h5 text-uppercase mb-4">Shopping cart</h2>
    <div class="row">
      <div class="col-lg-8 mb-4 mb-lg-0">
        <!-- CART TABLE-->
        <div class="table-responsive mb-4">
          <table class="table">
            <thead class="bg-light">
              <tr>
                <th class="border-0" scope="col"> <strong class="text-small text-uppercase">Product</strong></th>
                <th class="border-0" style="width: 12%;" scope="col"> <strong class="text-small text-uppercase">Price</strong></th>
                <th class="border-0" scope="col"> <strong class="text-small text-uppercase">Quantity</strong></th>
                <th class="border-0" style="width: 12%;" scope="col"> <strong class="text-small text-uppercase">Total</strong></th>
                <th class="border-0" scope="col"> </th>
              </tr>
            </thead>
            <tbody>
              @foreach (Cart::content() as $product)
              <tr>
                <th class="pl-0 border-0" scope="row">
                  <div class="media align-items-center"><a class="reset-anchor d-block animsition-link" href="/products/{{ $product->model->slug }}"><img src="{{ $product->model->image }}" alt="..." width="70" /></a>
                    <div class="media-body ml-3"><strong class="h6"><a class="reset-anchor animsition-link" href="/products/{{ $product->model->slug }}">{{ $product->model->title }}</a></strong></div>
                  </div>
                </th>
                <td class="align-middle border-0">
                  <p class="mb-0 small">{{ $product->model->getPrice() }}</p>
                </td>
                <td class="align-middle border-0">
                  <div class="border d-flex align-items-center justify-content-between px-3">
                    <span class="small text-uppercase text-gray headings-font-family">Quantity</span>
                    <div class="quantity">
                      <input id="qty" name="qty" class="form-control form-control-md border-0 shadow-0 p-0" type="number" min="1" max="8" data-id="{{ $product->rowId }} " value="{{ $product->qty }}" />
                    </div>
                  </div>
                </td>
                <td class="align-middle border-0">
                  <p class="mb-0 small">{{ $product->model->getPrice() }}</p>
                </td>
                <td class="align-middle border-0">
                  <form action="{{ route('cart.delete', $product->rowId) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="reset-anchor bg-transparent border-0"><i class="fas fa-trash-alt small text-muted"></i></button>
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
            <div class="col-md-6 text-md-right"><a class="btn btn-outline-dark btn-sm" href="{{ route('checkout') }}">Procceed to checkout<i class="fas fa-long-arrow-alt-right ml-2"></i></a></div>
          </div>
        </div>
      </div>
      <!-- ORDER TOTAL-->
      <divclass="col-lg-4">
        <div class="card border-0 rounded-0 p-lg-4 bg-light">
          <div id="totals" class="card-body">
            <h5 class="text-uppercase mb-4">Cart total</h5>
            <ul class="list-unstyled mb-0">
              <li class="d-flex align-items-center justify-content-between"><strong class="text-uppercase small font-weight-bold">Subtotal</strong><span class="text-muted small">{{ getPrice(Cart::subtotal()) }}</span></li>
              <li class="d-flex align-items-center justify-content-between"><strong class="text-uppercase small font-weight-bold">Tax</strong><span class="text-muted small">{{ getPrice(Cart::tax()) }}</span></li>
              <li class="border-bottom my-2"></li>
              <li class="d-flex align-items-center justify-content-between mb-4"><strong class="text-uppercase small font-weight-bold">Total</strong><span>{{ getPrice(Cart::total()) }}</span></li>
              <li>
                <form action="#">
                  <div class="form-group mb-0">
                    <input class="form-control" type="text" placeholder="Enter your coupon">
                    <button class="btn btn-dark btn-sm btn-block" type="submit"> <i class="fas fa-gift mr-2"></i>Apply coupon</button>
                  </div>
                </form>
              </li>
            </ul>
          </div>
        </div>
    </div>
</div>
</section>

@else
<div class="alert alert-danger m-5">
  Your cart is empty.
</div>
@endif
</div>
@endsection

@section('extra-js')
@include('layouts.jsFiles')

<script>
    var qty = document.querySelectorAll('#qty');
    Array.from(qty).forEach((element) => {
        element.addEventListener('change', function () {
            var rowId = element.getAttribute('data-id');
            var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch(`/cart/${rowId}`,
                {
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": token
                    },
                    method: 'PATCH',
                    body: JSON.stringify({
                        qty: this.value
                    })
            }).then((data) => {
                console.log(data);
                location.reload();
            }).catch((error) => {
                console.log(error);
            });
        });
    });
  // var select = document.querySelectorAll('#qty');

  // select.addEventListener('change', function() {
  //   var rowId = select.getAttribute('data-id');
  //   var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
  //   fetch(
  //     `/cart/${rowId}`, {
  //       headers: {
  //         "Content-Type": "application/json",
  //         "Accept": "application/json, text-plain, */*",
  //         "X-Requested-With": "XMLHttpRequest",
  //         "X-CSRF-TOKEN": token
  //       },
  //       method: 'PATCH',
  //       body: JSON.stringify({
  //         qty: select.value
  //       })
  //     }).then((data) => {
  //     console.log(data);
  //     location.reload();
  //   }).catch((error) => {
  //     console.log(`/cart/${rowId}`);
  //     console.log(error);
  //   })
  // })
</script>
@endsection