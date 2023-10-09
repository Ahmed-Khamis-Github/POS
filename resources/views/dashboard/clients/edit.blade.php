@extends('layouts.dashboard.app')
@section('page-title', __('site.edit'))

@section('bread-crumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">{{ __('site.Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('dashboard.users.index') }}">{{ __('site.users') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('site.add') }}</li>
@endsection

@section('content')

    <form action="{{ route('dashboard.clients.update',$client->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('partials._errors')
        @method('PUT')

          
     
        <div class="form-group">
            <label>@lang("site.name") </label>
            <input type="text" name="name" value="{{ $client->name }}" class="form-control">
        </div>


        <div class="form-group">
            <label>@lang("site.address") </label>
            <input type="text" name="address" value="{{ $client->address }}" class="form-control">
        </div>


        <div class="form-group">
            <label>@lang("site.phone") </label>
            <input type="text" name="phone[]" value="{{ $client->phone[0] }}"   class="form-control">
        </div>

        <div class="form-group">
            <label>@lang("site.phone[1]") </label>
            <input type="text" name="phone[]"  value="{{ $client->phone[1] }}"  class="form-control">
        </div>


 


        <button type="submit" class="btn btn-primary mt-3"><i class="fa fa-edit"></i> @lang('site.edit')</button>


    </form>

    



@endsection
