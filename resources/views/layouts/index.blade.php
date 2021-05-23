@extends('layouts.app')
@section('content')
<div class="container">
    @include('layouts.modal')
    @include('layouts.heroSection')
    @include('layouts.categories')
    @include('layouts.trendingProducts')
    </div>
    @include('layouts.jsFiles')
@endsection