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

    <div class="row justify-content-center p-5">
        <div class="col-xl-10">
            <form action=" {{ route('checkout.store') }}" method="POST" id="payment-form">
                <div class="row">
                    <div id="card-element" class="col-lg-8 form-group">
                        <!-- <label class="text-small text-uppercase" for="address">Card number</label>
                            <input class="form-control form-control-lg" id="address" type="text" placeholder="Card number">
                        </div>
                        <div class="col-sm-4 form-group">
                            <label class="text-small text-uppercase" for="address">ZIP Code</label>
                            <input class="form-control form-control-lg" id="address" type="text" maxlength="5" placeholder="Card number"> -->
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
                card: card
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
                                paymentIntent: paymentIntent
                            })
                            //when there's a positif return 
                        }).then((data) => {
                        if (data.status === 400) { // if the product is not available anymore
                            redirect = '/products'
                        }
                        //console.log(data);
                        //form.reset();
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