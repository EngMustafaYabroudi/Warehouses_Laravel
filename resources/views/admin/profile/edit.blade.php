@extends('layouts.admin.app')

@section('content')

    <div>
        <h2>@lang('users.edit_profile')</h2>
    </div>

    <ul class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">@lang('site.home')</a></li>
        <li class="breadcrumb-item">@lang('users.edit_profile')</li>
    </ul>

    <div class="row">

        <div class="col-md-12">

            <div class="tile shadow">

                <form method="post" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    @include('admin.partials._errors')

                    {{--name--}}
                    <div class="form-group">
                        <label>@lang('users.name')</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
                    </div>

                    {{--email--}}
                    <div class="form-group">
                        <label>@lang('users.email')</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
                    </div>

                    {{--image--}}
                    <div class="form-group">    
                        <label>@lang('users.image') <span class="text-danger">*</span></label>
                        <fieldset>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image_upload" >
                             <img src="{{asset("Admin/user_images/".auth()->user()->image)}}"  class="loaded-image" alt="" style="display: block; width: 200px; margin: 10px 0;">
                        </fieldset>
                        @error('image')
                        <small class="text-danger">{{$message}}</small>
                        @enderror 
                    </div>
                    {{----}}

                    {{--submit--}}
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> @lang('site.edit')</button>
                    </div>

                </form><!-- end of form -->

            </div><!-- end of tile -->

        </div><!-- end of col -->

    </div><!-- end of row -->
@endsection