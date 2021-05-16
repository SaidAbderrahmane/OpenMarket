@extends('boutique.app')
@section('content')
<div class="container">
    @include('boutique.modal')
    @include('boutique.heroSection')
    @include('boutique.categories')
    @include('boutique.trendingProducts')
    </div>
    @include('boutique.jsFiles')
@endsection