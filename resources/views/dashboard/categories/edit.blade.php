@extends('layouts.dashboard.app')
@section('page-title', __('site.Add'))

@section('bread-crumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">{{ __('site.Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('dashboard.users.index') }}">{{ __('site.users') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('site.add') }}</li>
@endsection

@section('content')

    <form action="{{ route('dashboard.categories.update',$category->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('partials._errors')
        @method('put')

     
        @foreach (config('translatable.locales') as  $locale)
         
     
        <div class="form-group">
            <label>@lang("site.$locale.name") </label>
            <input type="text" name="{{ $locale }}[name]" value="{{ $category->translate($locale)->name }}" class="form-control">
        </div>

       @endforeach
       



        <button type="submit" class="btn btn-primary mt-3"><i class="fa fa-plus"></i> @lang('site.Add')</button>


    </form>

    



@endsection
