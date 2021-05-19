@extends('dashboard.index')
@section('content')
@php
$i = 1;
@endphp
<h1 class="mt-4">Categories</h1>
<div class="pt-5">
    <button onclick="toggleDisplay('add');" type="button" class="btn btn-primary">
        add a category
    </button>
</div>

<div class="container p-2">
    <div class="row justify-content-center ">
        <div class="col-md-8">
            <div id="add" style="display:none" class="card mb-5">
                <div class="card-header"> Add a category</div>
                <div class="card-body">
                    <div class="p-2">
                        <form method="POST" action="/dashboard/categories" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row ">
                                <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('Image File :') }}</label>

                                <div class="col-md-6">
                                    <input id="image" type="file" class="file-control " name="image"  autofocus>
                                </div>

                                <label for=" name" class="col-md-4 col-form-label text-md-right">{{ __('Category Name :') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" required autofocus>
                                </div>

                                
                                <label for=" parentid" class="col-md-4 col-form-label text-md-right">{{ __('Parent Category (id) :') }}</label>

                                <div class="col-md-6">
                                <select name="parent" id="parentCat">
                                <option value="{{ $item->parent}}"></option>
                                </select>
                                    <input id="parentid" type="text" class="form-control" name="parentid" required autofocus>
                                </div>


                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        submit
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @foreach ($data as $item )

            <div class="card">
                <div class="card-header">{{ __('Categorie '.$i) }}</div>

                <div class="card-body">
                    <div class="alert alert-success">
                        {{ $item->name }}<br> parent category : {{ $item->parentid}}
                        <a style="float: right;" href="/category/delete/{{ $item->id }}">delete</a>
                        <a style="float: right; padding-right: 10px;" href="/category/edit/{{ $item->id }}" onclick="toggleDisplay('edit{{ $i }}');">edit </a>

                    </div>
                    <div>
                        <img src="{{ asset('images/'. $item->image) }}" width="500" height="250" alt="">
                    </div>
                    <div id="edit{{ _($i) }}" class="p-2" style="display:none">
                        <form method="POST" action="dashboard/categories">
                            @csrf

                            <div class="form-group row ">
                                <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('Image File :') }}</label>

                                <div class="col-md-6">
                                    <input id="image" type="file" class="file-control " name="image" required autofocus>
                                </div>

                                <label for=" name" class="col-md-4 col-form-label text-md-right">{{ __('Category Name :') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" value="{{ $item->name }}" name="name" required autofocus>
                                </div>

                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        submit
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>

                </div>
            </div>
            @php
            $i++;
            @endphp

            @endforeach
        </div>
    </div>
</div>
<script>
    function toggleDisplay(id) {
        var x = document.getElementById(id);
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
</script>

@endsection