@extends('layouts.dashboard.app')
@section('page-title', __('site.Add'))

@section('bread-crumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">{{ __('site.Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('dashboard.users.index') }}">{{ __('site.users') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('site.add') }}</li>
@endsection

@section('content')

    <form action="{{ route('dashboard.products.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('partials._errors')

        <div class="form-group">
            <label>@lang('site.categories')</label>
            <select name="category_id" class="form-control">
                <option value="">@lang('site.all_categories')</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

     @foreach (config('translatable.locales') as  $locale)
         
     
        <div class="form-group">
            <label>@lang("site.$locale.name") </label>
            <input type="text" name="{{ $locale }}[name]" value="{{ old($locale.'.name') }}" class="form-control">
        </div>

        <div class="form-group">
            <label>@lang("site.$locale.description")</label>
            <textarea class="form-control" rows="3" name="{{ $locale }}[description]">{{  old($locale.'.description') }}</textarea>
          </div>



       @endforeach

       <div class="form-group">
        <label>{{ __('site.image') }}</label>
        {{-- <input type="file" name="image" class="form-control"> --}}
        <input accept="image/*" name="image" class="form-control" type='file' id="imgInp" />
        <img id="blah" style="width: 100px" src="{{ asset('uploads/products_images/default.jpg') }}" alt="your image" />
    </div>


       <div class="form-group">
        <label>@lang('site.purchase_price')</label>
        <input type="number" name="purchase_price" step="0.01" class="form-control" value="{{ old('purchase_price') }}">
    </div>

    <div class="form-group">
        <label>@lang('site.sale_price')</label>
        <input type="number" name="sale_price" step="0.01" class="form-control" value="{{ old('sale_price') }}">
    </div>

    <div class="form-group">
        <label>@lang('site.stock')</label>
        <input type="number" name="stock" class="form-control" value="{{ old('stock') }}">
    </div>



        <button type="submit" class="btn btn-primary mt-3"><i class="fa fa-plus"></i> @lang('site.Add')</button>


    </form>

    <script>
        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                blah.src = URL.createObjectURL(file)
            }
        }
    </script>

    



@endsection
