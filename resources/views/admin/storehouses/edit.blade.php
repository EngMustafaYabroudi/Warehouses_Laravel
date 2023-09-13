@extends('layouts.admin.app')
@section('content')
    <div>
        <h2>@lang('storehouses.storehouses')</h2>
    </div>

    <ul class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">@lang('site.home')</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.storehouses.index') }}">@lang('storehouses.storehouses')</a></li>
        <li class="breadcrumb-item">@lang('site.create')</li>
    </ul>
    <div class="row">

        <div class="col-md-12">

            <div class="tile shadow">

                <form method="post" action="{{ route('admin.storehouses.update', $storehouse->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('put')


                    @include('admin.partials._errors')

                    {{--name--}}
                    <div class="form-group">
                        <label>@lang('storehouses.name') <span class="text-danger">*</span></label>
                        <input type="text" name="name" autofocus class="form-control" value="{{ old('name',$storehouse->name) }}" required>
                    </div>
                    {{--address--}}
                    <div class="form-group">
                        <label>@lang('storehouses.address') <span class="text-danger">*</span></label>
                        <input type="text" name="address" autofocus class="form-control" value="{{ old('address',$storehouse->address) }}" required>
                    </div>

                    <div class="form-group">
                        <label>@lang('storehouses.admin') <span class="text-danger">*</span></label>
                        <select name="user_id" id="user_id">
                            @foreach ($users as $user )
                            <option value="{{$user->id}}"{{ $user->id == old('user_id') ? 'selected' : '' }}>{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                   
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> @lang('site.update')</button>
                    </div>


                </form><!-- end of form -->

            </div><!-- end of tile -->

        </div><!-- end of col -->

    </div><!-- end of row -->


@endsection