@extends('layouts.app')
@section('content')
<!-- HERO SECTION-->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
            <div class="col-sm-6">
                <h1 class="h2 text-uppercase mb-0">Stores </h1>
            </div>
            <div class="col-sm-2 text-lg-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
                        <li class="breadcrumb-item"><a href="/stores">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Stores</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<section class="py-5">
    <div class="container p-0">
        <div class="row justify-content-center">
            <!-- SHOP LISTING-->
            <div class="col-lg-9 order-1 order-lg-2 mb-5 mb-lg-0">
                <div class="row mb-3 align-items-center">
                    <div class="col-sm-3 mb-2 mb-lg-0">
                        @if (request()->input('q'))
                        <p class="text-small text-muted mb-0">Showing 1–{{ $stores->total()>=12 ? 12 : $stores->total() }} of {{ $stores->total() }} of: {{ request()->q }}</p>
                        @else
                        <p class="text-small text-muted mb-0">Showing 1–{{ $stores->total()>=12 ? 12 : $stores->total() }} of {{ $stores->total() }} results</p>
                        @endif
                    </div>
                    <div class="col-sm-5">
                        <form class="form-inline my-2 my-lg-0" action="{{ route('stores.index') }}">
                            <input class="form-control mr-sm-2" type="search" name="q" value="{{ request()->q ?? ''}}" placeholder="Search" aria-label="Search" required>
                            <button class="btn btn-dark reset-anchor" type="submit"><i class="fas fa-search"></i></button>
                        </form>
                    </div>
                    <div class="col-sm-4">
                        <ul class="list-inline d-flex align-items-center justify-content-lg-end mb-0">
                            <li class="list-inline-item">
                                <select class="selectpicker ml-auto" id="sorting" name="sorting" data-width="200" data-style="bs-select-form-control" data-title="Default sorting">
                                    <option value="date" selected>Date</option>
                                </select>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    @foreach ($stores as $store)
                    <!-- STORE-->
                    <div class="col-lg-4 col-sm-6 mt-5">
                        <div class="product text-center">
                            <div class="mb-3 position-relative">
                                <div class="badge text-white badge-"></div><a class="d-block" href="{{ route('shop',['store' => $store->id ]) }}"><img class="img-fluid w-100" src="{{ asset('storage/'.$store->image) }}" alt="..."></a>
                                <div class="product-overlay">
                                    <ul class="mb-0 list-inline">
                                        <li class="list-inline-item mr-0"><a class="btn btn-sm btn-dark" href="{{ route('shop',['store' => $store->id ]) }}"> Visit store &rAarr;</a></li>
                                    </ul>
                                </div>
                            </div>
                            <h6> <a class="reset-anchor" href="{{ route('shop',['store' => $store->id ]) }}">{{ $store->name }}</a></h6>
                            <p class="medium text-muted">{{ $store->address}}</p>
                        </div>
                    </div>
                    @endforeach
                    <!-- in case of no results -->
                </div>
                @if($stores->total()===0)
                <div class="alert alert-info">no results to show</div>
                @endif
                <!-- PAGINATION-->
                {{ $stores->appends(request()->input())->links()}}
            </div>
        </div>
</section>
@endsection
@section('extra-js')
@include('layouts.jsFiles')
@endsection