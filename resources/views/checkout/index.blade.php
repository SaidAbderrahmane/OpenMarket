@extends('layouts.app')
@section('extra-script')
<script src="https://js.stripe.com/v3/"></script>
@endsection
@section('extra-meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')

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
                        <li class="breadcrumb-item"><a href="{{ route('shop') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cart') }}">Cart</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<section class="py-5">
    <!-- CARD INFO -->
    <h2 class="h5 text-uppercase mb-4">Payment details</h2>

    <div class="row">
        <div class="col-lg-8 justify-content-center p-5">
            <form action=" {{ route('checkout.store') }}" method="POST" id="payment-form">
                <div class="row">
                    <div class="col-lg-6 form-group">
                        <label class="text-small text-uppercase" for="firstName">First name</label>
                        <input class="form-control form-control-lg" id="firstName" type="text" placeholder="Enter your first name" required>
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="text-small text-uppercase" for="lastName">Last name</label>
                        <input class="form-control form-control-lg" id="lastName" type="text" placeholder="Enter your last name" required>
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="text-small text-uppercase" for="email">Email address</label>
                        <input class="form-control form-control-lg" id="email" type="email" placeholder="e.g. Jason@example.com" required>
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="text-small text-uppercase" for="phone">Phone number</label>
                        <input class="form-control form-control-lg" id="phone" type="tel" placeholder="e.g. +02 245354745" required>
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="text-small text-uppercase" for="country">Country</label>
                        <select class="selectpicker country" id="country" data-width="fit" data-flag="true" data-style="form-control form-control-lg" data-title="Select your country" required></select>
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="text-small text-uppercase" for="state">State</label>
                        <input class="form-control form-control-lg" id="state" type="text" required>
                    </div>
                    <div class="col-lg-12 form-group">
                        <label class="text-small text-uppercase" for="address">Address line 1</label>
                        <input class="form-control form-control-lg" id="address" type="text" placeholder="House number and street name" required>
                    </div>
                    <div class="col-lg-12 form-group">
                        <label class="text-small text-uppercase" for="address">Address line 2</label>
                        <input class="form-control form-control-lg" id="addressalt" type="text" placeholder="Apartment, Suite, Unit, etc (optional)">
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="text-small text-uppercase" for="city">Town/City</label>
                        <input class="form-control form-control-lg" id="city" type="text" required>
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="text-small text-uppercase" for="postal_code">Postal Code</label>
                        <input class="form-control form-control-lg" id="postal_code" type="text" pattern="[0-9]{5}" required>
                    </div>
                    <div id="card-element" class="col-lg-8 form-group mt-4">
                    </div>
                </div>
                <div class="row">
                    <div id="card-errors"></div>
                </div>
                <div class="row">
                    <div class="col-sm-5 form-group">
                        <button id="submit" class="btn btn-primary" type="submit">
                            <span id="spinner" class="spinner-grow d-none spinner-grow-sm" role="status"></span>
                            <span id="button-text">Pay now</span>
                        </button>
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
@section('extra-js')
<script>
    var stripe = Stripe('pk_test_51IuDBqFgbAj6W3MWZ7j39WaN8ZoCWVH3xWMty73jUPEiw6xkDNegt8xAhkXi2PLxcuJW4KaYZy4AZp1urto0LfCU00e0gOQ3vD');
    var elements = stripe.elements();
    var style = {
        base: {
            color: "#32325d",
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: "antialiased",
            fontSize: "18px",
            "::placeholder": {
                color: "#aab7c4"
            }
        },
        invalid: {
            color: "#fa755a",
            iconColor: "#fa755a"
        }
    };
    var card = elements.create("card", {
        style: style
    });
    const displayError = document.getElementById('card-errors');
    card.mount("#card-element");
    card.addEventListener('change', ({
        error
    }) => {

        if (error) {
            displayError.classList.add('alert', 'alert-warning', 'mt-3');
            displayError.textContent = error.message;
        } else {
            displayError.classList.remove('alert', 'alert-warning', 'mt-3');
            displayError.textContent = '';
        }
    });
    //soumission
    var submitButton = document.getElementById('submit');
    submitButton.addEventListener('click', function(ev) {
        loading(true);
        ev.preventDefault();
        submitButton.disabled = true;
        stripe.confirmCardPayment("{{ $clientSecret }}", {
            payment_method: {
                card: card,
                billing_details: {
                    address: {
                        city: document.getElementById('city').value,
                        country: document.getElementById('country').value,
                        line1: document.getElementById('address').value,
                        line2: document.getElementById('addressalt').value,
                        postal_code: document.getElementById('postal_code').value,
                        state: document.getElementById('state').value
                    },
                    email: document.getElementById('email').value,
                    name: document.getElementById('lastName').value + ' ' + document.getElementById('firstName').value,
                    phone: document.getElementById('phone').value
                }
            }
        }).then(function(result) {
            if (result.error) {
                loading(false);
                // Show error to your customer (e.g., insufficient funds)
                submitButton.disabled = false;
                displayError.classList.add('alert', 'alert-warning', 'mt-3');
                displayError.textContent = result.error.message;
                console.log(result.error.message);
            } else {
                // The payment has been processed!
                if (result.paymentIntent.status === 'succeeded') {
                    // Show a success message to your customer
                    // There's a risk of the customer closing the window before callback
                    // execution. Set up a webhook or plugin to listen for the
                    // payment_intent.succeeded event that handles any business critical
                    // post-payment actions.
                    loading(false);
                    var paymentIntent = result.paymentIntent;
                    var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    var form = document.getElementById('payment-form');
                    var url = form.action;
                    var redirect = '/thankyou';


                    //fetch request for AJAX
                    fetch(
                        url, {
                            headers: {
                                "Content-Type": "application/json",
                                "Accept": "application/json, text-plain, */*",
                                "X-Requested-With": "XMLHttpRequest",
                                "X-CSRF-TOKEN": token
                            },
                            method: 'post',
                            body: JSON.stringify({ //format passed data 
                                paymentIntent: paymentIntent,
                                email: document.getElementById('email').value,
                                name: document.getElementById('lastName').value + ' ' + document.getElementById('firstName').value,
                                phone: document.getElementById('phone').value,
                                city: document.getElementById('city').value,
                                country: document.getElementById('country').value,
                                line1: document.getElementById('address').value,
                                line2: document.getElementById('addressalt').value,
                                postal_code: document.getElementById('postal_code').value,
                                state: document.getElementById('state').value
                            })
                            //when there's a positif return 
                        }).then((data) => {
                        if (data.status === 400) { // if the product is not available anymore
                            redirect = '/products';
                        } else {
                            redirect = '/thankyou';
                        }
                        console.log(data);
                        form.reset();
                        window.location.href = redirect;

                    }).catch((error) => { //in case of error
                        console.log(error)
                    })
                }
            }
        });
    });

    // Show a spinner on payment submission
    var loading = function(isLoading) {
        if (isLoading) {
            // Disable the button and show a spinner
            document.querySelector("button").disabled = true;
            document.querySelector("#spinner").classList.remove("d-none");
            document.querySelector("#button-text").classList.add("d-none");
        } else {
            document.querySelector("button").disabled = false;
            document.querySelector("#spinner").classList.add("d-none");
            document.querySelector("#button-text").classList.remove("d-none");
        }
    };
</script>
@endsection