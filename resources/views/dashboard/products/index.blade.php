@extends('layouts.dashboard.app')
@section('bread-crumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">{{ __('site.Home') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('site.products') }}</li>
@endsection
@section('page-title', __('site.products'))


@section('content')
    <table class="table table-bordered table-hover">
        @include('partials._errors')
        <form action="{{ route('dashboard.products.index') }}" method="get">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="@lang('site.search')"
                        value="{{ request()->search }}">
                </div>

                <div class="col-md-4">
                    <select class="form-control" name="category_id">
                        <option value="">{{ __('site.all_categories') }}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request()->category_id==$category->id ? 'selected' :  '' }}>{{ $category->name }}</option>
                        @endforeach

                    </select>
                </div>

                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                    @if (Auth::user()->hasPermission('products_create'))
                        <a href="{{ route('dashboard.products.create') }}" class="btn btn-primary"><i
                                class="fa fa-plus"></i>
                            @lang('site.add')</a>
                    @else
                        <a href="{{ route('dashboard.products.create') }}" class="btn btn-primary disabled"><i
                                class="fa fa-plus"></i>
                            @lang('site.add')</a>
                    @endif
                </div>

            </div>
        </form>

        <thead>
            <tr>
                <th>#</th>
                <th>@lang('site.name')</th>
                <th>@lang('site.description')</th>
                <th>@lang('site.image')</th>
                <th>@lang('site.purchase_price')</th>
                <th>@lang('site.sale_price')</th>
                <th>@lang('site.stock')</th>
                <th>@lang('site.profit_percent')</th>
                <th>@lang('site.category_name')</th>
                <th>@lang('site.action')</th>

            </tr>
        </thead>

        <tbody>

            @foreach ($products as $product)
                <tr>
                    <td>{{ $loop->index }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td><img src="{{ $product->image_path  }}" style="width: 100px" class="img-thumbnail" alt="">
                    </td>
                    <td>{{ $product->purchase_price }}</td>
                    <td>{{ $product->sale_price }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->profit_percent }}%</td>
                    <td>{{ $product->category->name }}</td>


                    @if (Auth::user()->hasPermission('products_update'))
                        <td><a href="{{ route('dashboard.products.edit', $product->id) }}"
                                class="btn btn-sm btn-info">@lang('site.edit')</a>
                        @else
                        <td><a href="{{ route('dashboard.products.edit', $product->id) }}"
                                class="btn btn-sm btn-info disabled">@lang('site.edit')</a>
                    @endif
                    @if (Auth::user()->hasPermission('products_delete'))
                        <form action="{{ route('dashboard.products.destroy', $product->id) }}" method="post"
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


    {{ $products->appends(request()->query())->links() }}













@endsection
