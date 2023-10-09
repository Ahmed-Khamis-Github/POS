@extends('layouts.dashboard.app')
@section('page-title', __('site.Add'))

@section('bread-crumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">{{ __('site.Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('dashboard.users.index') }}">{{ __('site.users') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('site.add') }}</li>
@endsection

@section('content')

    <form action="{{ route('dashboard.clients.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('partials._errors')

          
     
        <div class="form-group">
            <label>@lang("site.name") </label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control">
        </div>


        <div class="form-group">
            <label>@lang("site.address") </label>
            <input type="text" name="address" value="{{ old('address') }}" class="form-control">
        </div>


        <div class="form-group">
            <label>@lang("site.phone") </label>
            <input type="text" name="phone[]"   class="form-control">
        </div>

        <div class="form-group">
            <label>@lang("site.phone[1]") </label>
            <input type="text" name="phone[]"   class="form-control">
        </div>


 


        <button type="submit" class="btn btn-primary mt-3"><i class="fa fa-plus"></i> @lang('site.Add')</button>


    </form>

    



@endsection
