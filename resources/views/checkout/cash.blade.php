@extends('layouts.app')
@section('extra-script')
<script src="https://js.stripe.com/v3/"></script>
@endsection
@section('content')
@include('layouts.modal')
<div class="container">
  <!-- HERO SECTION-->
  <section class="py-5 bg-light">
    <div class="container">
      <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
        <div class="col-lg-6">
          <h1 class="h2 text-uppercase mb-0">Checkout</h1>
        </div>
        <div class="col-lg-6 text-lg-right">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
              <li class="breadcrumb-item"><a href="index.html">Home</a></li>
              <li class="breadcrumb-item"><a href="cart.html">Cart</a></li>
              <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </section>
  <section class="py-5">
    <!-- BILLING ADDRESS-->
    <h2 class="h5 text-uppercase mb-4">Billing details</h2>
    <div class="row">
      <div class="col-lg-8">
        <form action="{{ route('checkout.cash.store') }}" method="POST">
          @csrf
          @method('POST')
          <div class="row">
            <div class="col-lg-6 form-group">
              <label class="text-small text-uppercase" for="firstName">First name</label>
              <input class="form-control form-control-lg" id="firstName" name="firstName" type="text" placeholder="Enter your first name" required>
            </div>
            <div class="col-lg-6 form-group">
              <label class="text-small text-uppercase" for="lastName">Last name</label>
              <input class="form-control form-control-lg" id="lastName" name="lastName" type="text" placeholder="Enter your last name" required>
            </div>
            <div class="col-lg-6 form-group">
              <label class="text-small text-uppercase" for="email">Email address</label>
              <input class="form-control form-control-lg" id="email" name="email" type="email" placeholder="e.g. Jason@example.com" required>
            </div>
            <div class="col-lg-6 form-group">
              <label class="text-small text-uppercase" for="phone">Phone number</label>
              <input class="form-control form-control-lg" id="phone" name="phone" type="tel" placeholder="e.g. +02 245354745" required>
            </div>
            <div class="col-lg-6 form-group">
              <label class="text-small text-uppercase" for="country">Country</label>
              <select class="selectpicker country" id="country" name="country" data-width="fit" data-flag="true" data-style="form-control form-control-lg" data-title="Select your country" required></select>
            </div>
            <div class="col-lg-6 form-group">
              <label class="text-small text-uppercase" for="state">State</label>
              <input class="form-control form-control-lg" id="state" name="state" type="text" required>
            </div>
            <div class="col-lg-12 form-group">
              <label class="text-small text-uppercase" for="address">Address line 1</label>
              <input class="form-control form-control-lg" id="address" name="line1" type="text" placeholder="House number and street name" required>
            </div>
            <div class="col-lg-12 form-group">
              <label class="text-small text-uppercase" for="address">Address line 2</label>
              <input class="form-control form-control-lg" id="addressalt" name="line2" type="text" placeholder="Apartment, Suite, Unit, etc (optional)">
            </div>
            <div class="col-lg-6 form-group">
              <label class="text-small text-uppercase" for="city">Town/City</label>
              <input class="form-control form-control-lg" id="city" name="city" type="text" required>
            </div>
            <div class="col-lg-6 form-group">
              <label class="text-small text-uppercase" for="postal_code">Postal Code</label>
              <input class="form-control form-control-lg" id="postal_code" name="postal_code" type="text" pattern="[0-9]{5}" required>
            </div>

            <div class="col-lg-12 form-group">
              <button class="btn btn-dark" type="submit">Place order</button>
            </div>
          </div>
        </form>
      </div>
      <!-- ORDER SUMMARY-->
      <div class="col-lg-4">
        <div class="card border-0 rounded-0 p-lg-4 bg-light">
          <div id="totals" class="card-body">
            <h5 class="text-uppercase mb-4">Cart total</h5>
            <ul class="list-unstyled mb-0">
              <li class="d-flex align-items-center justify-content-between"><strong class="text-uppercase small font-weight-bold">Subtotal</strong><span class="text-muted small">{{ getPrice(Cart::subtotal()) }}</span></li>
              @if(request()->session()->has('coupon'))
              <li class="d-flex align-items-center justify-content-between"><strong class="text-uppercase small font-weight-bold">Coupon [{{ request()->session()->get('coupon')['code'] }}]</strong>
                <form action="{{ route('coupon.destroy') }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="reset-anchor bg-transparent border-0"><i class="fas fa-times small text-muted"></i></button>
                </form>
                <span class="text-muted small">-{{ getPrice(request()->session()->get('coupon')['discount']) }}</span>
              </li>
              <li class="d-flex align-items-center justify-content-between"><strong class="text-uppercase small font-weight-bold">New subtotal</strong><span class="text-muted small">{{ getPrice(request()->session()->get('coupon')['new_subtotal']) }}</span></li>
              @endif
              <li class="d-flex align-items-center justify-content-between"><strong class="text-uppercase small font-weight-bold">Tax</strong><span class="text-muted small">{{ request()->session()->has('coupon') ? getPrice(request()->session()->get('coupon')['new_tax']) : getPrice(Cart::tax()) }}</span></li>
              <li class="border-bottom my-2"></li>
              <li class="d-flex align-items-center justify-content-between mb-4"><strong class="text-uppercase small font-weight-bold">Total</strong><span>{{ request()->session()->has('coupon') ? getPrice(request()->session()->get('coupon')['new_total']) : getPrice(Cart::total()) }}</span></li>
              @if(!request()->session()->has('coupon'))
              <!--COUPON-->
              <li>
                <form action="{{ route('coupon.store') }}" method="POST">
                  @csrf
                  <div class="form-group mb-0">
                    <input class="form-control" type="text" name="code" placeholder="Enter your coupon">
                    <button class="btn btn-dark btn-sm btn-block" type="submit"> <i class="fas fa-gift mr-2"></i>Apply coupon</button>
                  </div>
                </form>
              </li>
              @else
              <li>
                <div class="form-group mb-0">
                  <div class="alert alert-success">A coupon is already applied.</p>
                  </div>
              </li>
              @endif
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@include('layouts.jsFiles')
@endsection