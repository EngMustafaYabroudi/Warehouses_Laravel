@extends('layouts.admin.app')
@section('content')
    <div>
        <h2>@lang('category.categories')</h2>
    </div>

    <ul class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">@lang('site.home')</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.category.index') }}">@lang('category.categories')</a></li>
        <li class="breadcrumb-item">@lang('site.create')</li>
    </ul>
    <div class="row">

        <div class="col-md-12">

            <div class="tile shadow">

                <form method="post" action="{{ route('admin.category.store') }} " enctype="multipart/form-data">
                    @csrf
                    @method('post')

                    @include('admin.partials._errors')

                    {{--name--}}
                    <div class="form-group">
                        <label>@lang('category.name') <span class="text-danger">*</span></label>
                        <input type="text" name="name" autofocus class="form-control" value="{{ old('name') }}" required>
                    </div>
                    {{--description--}}
                    <div class="form-group">
                        <label>@lang('category.description') <span class="text-danger">*</span></label>
                        <input type="text" name="description" autofocus class="form-control" value="{{ old('description') }}" required>
                    </div>
                    
                    {{--Image --}}
                    {{-- <div class="col-md-6  mb-3">
                        <label>Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" enctype="multipart/form-data" >
                        @error('image')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div> --}}
                    {{--image--}}
                    <div class="form-group">
                        
                        <label>@lang('users.image') <span class="text-danger">*</span></label>
                        <fieldset>
                            @method('post')
                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image_upload" enctype="multipart/form-data" >
                        </fieldset>
                        @error('image')
                        <small class="text-danger">{{$message}}</small>
                        @enderror 
                    </div>
                    {{----}}

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('site.create')</button>
                    </div>

                </form><!-- end of form -->

            </div><!-- end of tile -->

        </div><!-- end of col -->

    </div><!-- end of row -->


@endsection