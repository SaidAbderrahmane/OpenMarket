@extends('dashboard.index')
@section('content')
<div id="add"  style="display:none" class="card mb-5">
                <div class="card-header"> Add a category</div>
                <div class="card-body">
                    <div class="p-2">
                        <form method="POST" action="/dashboard/categories">
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
@endsection