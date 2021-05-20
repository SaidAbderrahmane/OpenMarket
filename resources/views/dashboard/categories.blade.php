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
                                    <input id="image" type="file" class="file-control " name="image" required autofocus>
                                </div>

                                <label for=" name" class="col-md-4 col-form-label text-md-right">{{ __('Category Name :') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" required autofocus>
                                </div>

                                <label for="parentid" class="col-md-4 col-form-label text-md-right mt-2 ">{{ __('Parent Category (id) :') }}</label>
                                <div class="col-md-6 mt-2">
                                    <select class="custom-select" name="parentid" id="parentid">
                                        <option value=""> none</option>
                                        @foreach ($data as $item)
                                        <option value="{{ $item->id }}"> {{ $item->name }} </option>
                                        @endforeach
                                    </select>
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

            <div class="card mb-5">
                <div class="card-header">{{ __('Categorie '.$i) }}</div>

                <div class="card-body">
                    <div class="alert alert-success pb-5">
                        {{ $item->name }}<br> parent category :
                        @if ($item->parent != null)
                        {{ $item->parent->name }}
                        @else none
                        @endif

                        <a style="float: right; padding-right: 10px;" href="#!" onclick="toggleDisplay('edit{{ $i }}');">Edit &rAarr; </a>
                        <form action="/dashboard/categories/{{ $item->id }}" method="POST">
                            @csrf
                            @method('delete')

                            <button type="submit" style="background-color: transparent; border:none; color:red; float:right;">
                                Delete &rAarr;
                            </button>

                        </form>
                    </div>
                    <div style="text-align: center;">
                        <img src="{{ asset('images/'. $item->image) }}" height="250" alt="">
                    </div>


                    <div id="edit{{ _($i) }}" class="mt-3" style="display:none">
                        <form method="POST" action="/dashboard/categories/{{ $item->id }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group row ">
                                <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('Image File :') }}</label>

                                <div class="col-md-6">
                                    <input id="image" name="image" type="file" class="file-control" autofocus>
                                </div>

                                <label for=" name" class="col-md-4 col-form-label text-md-right">{{ __('Category Name :') }}</label>

                                <div class="col-md-6">
                                    <input id="name" name="name" type="text" class="form-control" value="{{ $item->name }}" required autofocus>
                                </div>

                                <label for="parentid" class="col-md-4 col-form-label text-md-right mt-2 ">
                                    {{ __('Parent Category (id) :')}}
                                </label>
                                <div class="col-md-6 mt-2">
                                    <select class="custom-select" name="parentid" id="parentid{{$i}}">
                                        <option value=""> none</option>
                                        @foreach ($data as $cat)
                                        @if($cat->id != $item->id)
                                        <option value="{{ $cat->id }}"> {{ $cat->name }} </option>
                                        @endif
                                        <script>
                                            document.getElementById("parentid{{$i}}").value = "{{ $item->parentid }}";
                                        </script>
                                        @endforeach
                                    </select>
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