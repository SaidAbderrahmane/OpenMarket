@extends('layouts.app')


@section('content')
<!-- HERO SECTION-->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
            <div class="col-lg-6">
                <h1 class="h2 text-uppercase mb-0">Orders</h1>
            </div>
            <div class="col-lg-6 text-lg-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
                        <li class="breadcrumb-item"><a href="{{ route('shop') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('users.edit') }}">Profile</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Orders</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <h2 class="h5 text-uppercase mb-4">Orders list</h2>
    <div class="row">
        <div class="col ">
            <!-- ORDERS TABLE-->
            <div class="table-responsive mb-4">
                @if (Auth()->user()->orders->isNotEmpty())
                <table class="table">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0" scope="col"> <strong class="text-small text-uppercase">Order date</strong></th>
                            <th class="border-0" scope="col"> <strong class="text-small text-uppercase">Order Details</strong></th>
                            <th class="border-0" scope="col"> <strong class="text-small text-uppercase">Total</strong></th>
                            <th class="border-0" scope="col"> <strong class="text-small text-uppercase">Status</strong></th>
                            <th class="border-0" scope="col"> <strong class="text-small text-uppercase">Payment Method</strong></th>
                            <th class="border-0" scope="col"> <strong class="text-small text-uppercase">Shipping Address</strong></th>
                            <th class="border-0" style="width: 12%;" scope="col"> <strong class="text-small text-uppercase">Client Info</strong></th>
                            <th class="border-0" scope="col"> </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (Auth::user()->orders as $order)
                        <tr>
                            <td class="align-middle border-0">
                                <p class="mb-0 small">{{ Carbon\Carbon::parse($order->payment_created_at)->format('d/m/y - H:i') }}</p>
                            </td>
                            <td class="align-middle border-0">
                                <table class="table">
                                    <tr class="border bg-light ">
                                        <th class="mb-0 small">Name</th>
                                        <th class="mb-0 small">Price</th>
                                        <th class="mb-0 small">Qty</th>
                                        <th class="mb-0 small">Subtotal</th>
                                    </tr>
                                    @foreach (App\Models\OrderLine::where('order_id',$order->id)->get() as $orderLine)
                                    <tr>
                                        <td class="mb-0 small">{{ $orderLine->product->title }}</td>
                                        <td class="mb-0 small">{{ getPrice($orderLine->price) }}</td>
                                        <td class="mb-0 small">{{ $orderLine->quantity }}</td>
                                        <td class="mb-0 small">{{ getPrice($orderLine->price*$orderLine->quantity) }}</td>
                                    </tr>
                                    @endforeach
                                </table>
                            </td>
                            <td class="align-middle border-0">
                                <p class="mb-0 small">{{ getPrice($order->amount) }}</p>
                            </td>
                            <td class="align-middle border-0">
                                <p class="mb-0 small">{{$order->status}}</p>
                            </td>
                            <td class="align-middle border-0">
                                <p class="mb-0 small">Credit Card</p>
                            </td>
                            <td class="align-middle border-0">
                                <ul>
                                    <li class="mb-0 small">{{ $order->country }}, {{ $order->state }}, {{ $order->city }}</li>
                                    <li class="mb-0 small"><strong>Address line 1:</strong></strong> {{ $order->line1}}</li>
                                    <li class="mb-0 small"><strong>Address line 2:</strong> {{ $order->line2}}</li>
                                    <li class="mb-0 small"><strong>Zip code: </strong>{{ $order->postal_code}}</li>
                                </ul>
                            </td>
                            <td class="align-middle border-0">
                                <ul>
                                    <li class="mb-0 small"><strong> Name: </strong> {{ $order->name}}</li>
                                    <li class="mb-0 small"><strong>Email: </strong>{{ $order->email}}</li>
                                    <li class="mb-0 small"><strong>Phone: </strong>{{ $order->phone}}</li>
                                </ul>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="alert alert-danger">
                    <p>You don't have orders yet.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
@section('extra-js')
@include('layouts.jsFiles')
@endsection