@extends('layouts.dashboard.app')
@section('bread-crumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">{{ __('site.Home') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('site.categories') }}</li>
@endsection
@section('page-title', __('site.categories') )


@section('content')
    <table class="table table-bordered table-hover">
        @include('partials._errors')
        <form action="{{ route('dashboard.categories.index') }}" method="get">
        <div class="row">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search }}">
            </div>
             <div class="col-md-4">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                @if(Auth::user()->hasPermission('categories_create') )
                <a href="{{ route('dashboard.categories.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i>
                    @lang('site.add')</a>
                    @else
                    <a href="{{ route('dashboard.categories.create') }}" class="btn btn-primary disabled"><i class="fa fa-plus"></i>
                        @lang('site.add')</a>
                    @endif
            </div>
                 
         </div>
        </form>

        <thead>
            <tr>
                <th>#</th>
                <th>@lang('site.name')</th>
                 
                <th>@lang('site.count')</th>

                <th>@lang('site.action')</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($categories as $category)
                <tr>
                    <td>{{ $loop->index }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->products->count() }}</td>

                    
                    <td><a href="{{ route('dashboard.products.index', ['category_id'=>$category->id]) }}"
                        class="btn btn-sm btn-info">@lang('site.Show Related Products')</a>
                          
                         
                </td>

                    @if(Auth::user()->hasPermission('categories_update') )

                    <td><a href="{{ route('dashboard.categories.edit', $category->id) }}"
                            class="btn btn-sm btn-info">@lang('site.edit')</a>
                            @else
                            <td><a href="{{ route('dashboard.categories.edit', $category->id) }}"
                                class="btn btn-sm btn-info disabled">@lang('site.edit')</a>
                        @endif
                        @if(Auth::user()->hasPermission('categories_delete') )

                        <form action="{{ route('dashboard.categories.destroy', $category->id) }}" method="post"
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
     

    {{ $categories->appends(request()->query())->links() }}
 












@endsection
