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

                <form method="post" action="{{ route('admin.Storehouse_mangament.products.store') }} " enctype="multipart/form-data">
                    @csrf
                    @method('post')

                    @include('admin.partials._errors')

                    {{----}}
                    <table class="table table-bordered" id="dynamicAddRemove">
                        <tr>
                            <th>Product</th>
                            <th>Boxes</th>
                            <th>Action</th>
                        </tr>
                        <tr>
                            
                            <td>
                                <select name="product_id[0]">
                                    <option value=""> --Please choose an option--</option>
                                    @foreach ($products as $product)
                                    <option value="{{$product->id}}">{{$product->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                {{--name--}}
                                {{-- <div class="form-group"> --}}
                                    {{-- <label>@lang('product.boxes') <span class="text-danger">*</span></label> --}}
                                    <input type="text" name="boxes[0]" autofocus class="form-control" value="{{ old('boxes') }}" required>
                                {{-- </div> --}}
                            </td>
                            <td>
                                <button type="button" name="add" id="dynamic-ar" class="btn btn-outline-primary">Add Product</button>
                            </td>
                        </tr>
                    </table>
                    {{-- <button type="submit" class="btn btn-outline-success btn-block">Save</button> --}}

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('site.create')</button>
                    </div>

                </form><!-- end of form -->

            </div><!-- end of tile -->

        </div><!-- end of col -->

    </div><!-- end of row -->
<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
    var i = 0;
    $("#dynamic-ar").click(function () {
        ++i;
        $("#dynamicAddRemove").append('<tr><td><select name="product_id['+i+']"><option value=""> --Please choose an option--</option>@foreach ($products as $product)<option value="{{$product->id}}">{{$product->name}}</option>@endforeach </select></td><td><input type="text" name="boxes['+i+']" autofocus class="form-control" value="{{ old('boxes') }}" required></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>'
            );
    });
    $(document).on('click', '.remove-input-field', function () {
        $(this).parents('tr').remove();
    });
</script>

@endsection
