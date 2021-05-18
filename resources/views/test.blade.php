@extends('boutique.app')
@section('content')
@php
$i = 1;
@endphp

<div class="container p-2">
    <div class="row justify-content-center ">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Product '.$i) }}</div>

                <div class="card-body">
                        <div class="alert alert-success" >
                          {{ $product->title }}
                        </div>  
                </div>
            </div>
        </div>
    </div>
</div>
@php
  $i++;   
@endphp

@endsection
