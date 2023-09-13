@extends('layouts.admin.app')
@section('content')
    <div>
        <h2>@lang('product.products')</h2>
    </div>

    <ul class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">@lang('site.home')</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.product.index') }}">@lang('product.products')</a></li>
        <li class="breadcrumb-item">@lang('site.create')</li>
    </ul>
    <div class="row">

        <div class="col-md-12">

            <div class="tile shadow">

                <form method="post" action="{{ route('admin.product.store') }} " enctype="multipart/form-data">
                    @csrf
                    @method('post')

                    @include('admin.partials._errors')

                    {{--name--}}
                    <div class="form-group">
                        <label>@lang('product.name') <span class="text-danger">*</span></label>
                        <input type="text" name="name" autofocus class="form-control" value="{{ old('name') }}" required>
                    </div>
                    {{-- category_id--}}
                    <div class="form-group">
                        <label>@lang('category.category') <span class="text-danger">*</span></label>
                        <select name="category_id" id="category_id">
                            <option value=""> --Please choose an option--</option>
                            @foreach ($categories as $category )
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    {{--}}
                    {{--price--}}
                    <div class="form-group">
                        <label>@lang('product.price') <span class="text-danger">*</span></label>
                        <input type="text" name="price" autofocus class="form-control" value="{{ old('price') }}" required>
                    </div>
                    {{----}}
                    {{--number_boxes--}}
                    <div class="form-group">
                        <label>@lang('product.boxes') <span class="text-danger">*</span></label>
                        <input type="text" name="number_boxes" autofocus class="form-control" value="{{ old('number_boxes') }}" required>
                    </div>
                    {{----}}
                    {{--expiry_date--}}
                    <div class="form-group">
                        <label>@lang('product.expiry_date') <span class="text-danger">*</span></label>
                        <input type="date" name="expiry_date" autofocus class="form-control" value="{{ old('expiry_date') }}" required>
                    </div>
                    {{--description--}}
                    <div class="form-group">
                        <label>@lang('product.description') <span class="text-danger">*</span></label>
                        <input type="text" name="description" autofocus class="form-control" value="{{ old('description') }}" required>
                    </div>
                    
                    {{----}}
                    <div class="form-group">
                        
                        <label>@lang('product.image') <span class="text-danger">*</span></label>
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