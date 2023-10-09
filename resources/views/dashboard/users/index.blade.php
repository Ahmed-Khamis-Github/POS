@extends('layouts.dashboard.app')
@section('bread-crumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">{{ __('site.Home') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('site.users') }}</li>
@endsection
@section('page-title', __('site.users') )


@section('content')
    <table class="table table-bordered table-hover">
        @include('partials._errors')
        <form action="{{ route('dashboard.users.index') }}" method="get">
        <div class="row">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search }}">
            </div>
             <div class="col-md-4">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                @if(Auth::user()->hasPermission('users_create') )
                <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i>
                    @lang('site.add')</a>
                    @else
                    <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary disabled"><i class="fa fa-plus"></i>
                        @lang('site.add')</a>
                    @endif
            </div>
                 
         </div>
        </form>

        <thead>
            <tr>
                <th>#</th>
                <th>@lang('site.first_name')</th>
                <th>@lang('site.last_name')</th>
                <th>@lang('site.email')</th>
                <th>@lang('site.image')</th>
                <th>@lang('site.action')</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($users as $user)
                <tr>
                    <td>{{ $loop->index }}</td>
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><img src="{{  $user->image_path   }}" style="width: 100px" class="img-thumbnail" alt=""></td>

                    @if(Auth::user()->hasPermission('users_update') )

                    <td><a href="{{ route('dashboard.users.edit', $user->id) }}"
                            class="btn btn-sm btn-info">@lang('site.edit')</a>
                            @else
                            <td><a href="{{ route('dashboard.users.edit', $user->id) }}"
                                class="btn btn-sm btn-info disabled">@lang('site.edit')</a>
                        @endif
                        @if(Auth::user()->hasPermission('users_delete') )

                        <form action="{{ route('dashboard.users.destroy', $user->id) }}" method="post"
                            style="display: inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">@lang('site.Delete')</button>
                             
                    </td>
                    </form>
                    @else 
                    <button type="submit" class="btn btn-sm btn-danger disabled">@lang('site.Delete')</button>
                    @endif
                </tr>
            @endforeach

        </tbody>
    </table>
     

    {{ $users->appends(request()->query())->links() }}
 












@endsection
