@extends('boutique.app')
@section('content')
@php
$i = 1;
@endphp

@foreach ($data as $item )

<div class="container p-2">
    <div class="row justify-content-center ">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Categorie '.$i) }}</div>

                <div class="card-body">
                        <div class="alert alert-success" >
                          {{  $item->name }}
                        </div>
                        <div>
                        <img src="{{ $item->image }}" alt="">
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@php
  $i++;   
@endphp

@endforeach
@endsection
