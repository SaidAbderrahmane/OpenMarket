@extends('layouts.app')
@section('content')

<!-- HERO SECTION-->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row px-4 px-lg-5 py-lg-4 justify-content-between">
            <div class="col-sm-4">
                <h1 class="h2 text-uppercase mb-0">Store owner dashboard</h1>
            </div>
            <div class="col-sm-4 self-align-end text-lg-right ">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
                        <li class="breadcrumb-item"><a href="/products">Home</a></li>
                        <li class="breadcrumb-item"><a href="/store-owner">Store Owner Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Recieved Orders</li>
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

                <a class="reset-anchor" href="{{ route('store_owner.stores') }}">
                    <div class="py-2 px-4 bg-light mb-3"><strong class="small text-uppercase font-weight-bold">My stores </strong></div>
                </a>
                <a class="reset-anchor" href="{{ route('store_owner.products') }}">
                    <div class="py-2 px-4 bg-light mb-3"><strong class="small text-uppercase font-weight-bold">My products</strong></div>
                </a>
                <a class="reset-anchor" href="#">
                    <div class="py-2 px-4 bg-dark text-light mb-3"><strong class="small text-uppercase font-weight-bold">Recieved Orders </strong></div>
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
    <div class="content" style="margin:0 10% 0 10%;">
        <h2 class="h5 text-uppercase mb-4">Orders list</h2>
        <div class="row mb-3 align-items-center">
            <div class="col-sm-3 mb-2 mb-lg-0">
                @if (request()->input('q'))
                <p class="text-small text-muted mb-0">Showing 1–{{ $orders->total()>=10 ? 10 : $orders->total() }} of {{ $orders->total() }} of: {{ request()->q }}</p>
                @else
                <p class="text-small text-muted mb-0">Showing 1–{{ $orders->total()>=10 ? 10 : $orders->total() }} of {{ $orders->total() }} results</p>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col ">
                <!-- ORDERS TABLE-->
                <div class="table-responsive mb-4">
                    @if ($orders->isNotEmpty())
                    <table class="table">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0" scope="col"> <strong class="text-small text-uppercase">Order date</strong></th>
                                <th class="border-0" scope="col"> <strong class="text-small text-uppercase">Order Details</strong></th>
                                <th class="border-0" scope="col"> <strong class="text-small text-uppercase">Total</strong></th>
                                <th class="border-0" scope="col"> <strong class="text-small text-uppercase">Status</strong></th>
                                <th class="border-0" scope="col"> <strong class="text-small text-uppercase">Payment Method</strong></th>
                                <th class="border-0" scope="col"> <strong class="text-small text-uppercase">Paid</strong></th>
                                <th class="border-0" scope="col"> <strong class="text-small text-uppercase">Shipping Address</strong></th>
                                <th class="border-0" style="width: 12%;" scope="col"> <strong class="text-small text-uppercase">Client Info</strong></th>
                                <th class="border-0" scope="col"> </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr>
                                <td class="align-middle border-0">
                                    <p class="mb-0 small">{{ $order->created_at }}</p>
                                </td>
                                <td class="align-middle border-0">
                                    <table class="table">
                                        <tr class="border bg-light ">
                                            <th class="mb-0 small">Name</th>
                                            <th class="mb-0 small">Price</th>
                                            <th class="mb-0 small">Qty</th>
                                            <th class="mb-0 small">Subtotal</th>
                                            <th class="mb-0 small">Store</th>
                                        </tr>
                                        @foreach (App\Models\OrderLine::where('order_id',$order->id)->get() as $orderLine)
                                        @if (in_array($orderLine->product->store->id, $store_ids))
                                        <tr>
                                            <td class="mb-0 small">{{ $orderLine->product->title }}</td>
                                            <td class="mb-0 small">{{ getPrice($orderLine->price) }}</td>
                                            <td class="mb-0 small">{{ $orderLine->quantity }}</td>
                                            <td class="mb-0 small">{{ getPrice($orderLine->price*$orderLine->quantity) }}</td>
                                            <td class="mb-0 small">{{ $orderLine->product->store->name }}</td>
                                        </tr>
                                        @endif
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
                                    <p class="mb-0 small">{{$order->payment_method}}</p>
                                </td>
                                <td class="align-middle border-0">
                                    <p class="mb-0 small">{{$order->paid==1 ? 'paid' : 'not paid'}}</p>
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
                    {{ $orders->appends(request()->input())->links()}}
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('extra-js')
@include('layouts.jsFiles')
@endsection