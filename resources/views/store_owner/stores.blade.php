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
                        <li class="breadcrumb-item active" aria-current="page">Stores</li>
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

                <a class="reset-anchor" href="#">
                    <div class="py-2 px-4 bg-dark text-light mb-3"><strong class="small text-uppercase font-weight-bold">My stores </strong></div>
                </a>
                <a class="reset-anchor" href="{{ route('store_owner.products') }}">
                    <div class="py-2 px-4 bg-light mb-3"><strong class="small text-uppercase font-weight-bold">My products</strong></div>
                </a>
                <a class="reset-anchor" href="{{ route('store_owner.orders') }}">
                    <div class="py-2 px-4 bg-light mb-3"><strong class="small text-uppercase font-weight-bold">Recieved Orders </strong></div>
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
    <div class="container">
        <h2 class="h5 text-uppercase mb-4">Stores list</h2>
        <a href="{{ route('store_owner.stores.add') }}" class="btn btn-success">Add a store</a>
        <div class="row mb-3 align-items-center">
            <div class="col-sm-3 mb-2 mb-lg-0">
                @if (request()->input('q'))
                <p class="text-small text-muted mb-0">Showing 1–{{ $stores->total()>=15 ? 15 : $stores->total() }} of {{ $stores->total() }} of: {{ request()->q }}</p>
                @else
                <p class="text-small text-muted mb-0">Showing 1–{{ $stores->total()>=15 ? 15 : $stores->total() }} of {{ $stores->total() }} results</p>
                @endif
            </div>
            <div class="col-sm-5">
                <form class="form-inline my-2 my-lg-0" action="{{ route('store_owner.stores') }}">
                    <input class="form-control mr-sm-2" type="search" name="q" value="{{ request()->q ?? ''}}" placeholder="Search" aria-label="Search" required>
                    <button class="btn btn-dark reset-anchor" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col ">
                <!-- STORES TABLE-->
                <div class="table-responsive mb-4">
                    @if ($stores->isNotEmpty())
                    <table class="table">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0" scope="col"> <strong class="text-small text-uppercase">Name</strong></th>
                                <th class="border-0" scope="col"> <strong class="text-small text-uppercase">Address</strong></th>
                                <th class="border-0" scope="col"> <strong class="text-small text-uppercase">Image</strong></th>
                                <th class="border-0" scope="col"> <strong class="text-small text-uppercase">Actions</strong></th>
                                <th class="border-0" scope="col"> </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stores as $store)
                            <tr>
                                <td class="align-middle border-0">
                                    <p class="mb-0 small">{{ $store->name }}</p>
                                </td>
                                <td class="align-middle border-0">
                                    <p class="mb-0 small">{{ $store->address }}</p>
                                </td>
                                <td class="align-middle border-0">
                                    <img class="img-fluid" style="width: 200px;" src="{{ asset('storage/'.$store->image) }}" alt="no image">
                                </td>
                                <td class="align-middle border-0">
                                    <ul style="list-style: none;">
                                        <li class="mb-0"><a class="btn btn-sm btn-outline-success m-1" href="{{ route('store_owner.stores.view',$store->id) }}">view</a></li>
                                        <li class="mb-0"><a class="btn btn-sm btn-outline-info m-1" href="{{ route('store_owner.stores.edit',$store->id) }}">edit</a></li>
                                        <li class="mb-0">
                                            <form action="{{ route('store.destroy',$store->id) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-sm btn-outline-danger m-1" type="submit">delete</button>
                                            </form>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="alert alert-danger">
                        <p>You don't have stores yet.</p>
                    </div>
                    @endif
                    {{ $stores->appends(request()->input())->links()}}
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('extra-js')
@include('layouts.jsFiles')
@endsection