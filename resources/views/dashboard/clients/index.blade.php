@extends('layouts.dashboard.app')
@section('bread-crumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">{{ __('site.Home') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('site.clients') }}</li>
@endsection
@section('page-title', __('site.clients'))


@section('content')
    <table class="table table-bordered table-hover">
        @include('partials._errors')
        <form action="{{ route('dashboard.clients.index') }}" method="get">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="@lang('site.search')"
                        value="{{ request()->search }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                    @if (Auth::user()->hasPermission('clients_create'))
                        <a href="{{ route('dashboard.clients.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i>
                            @lang('site.add')</a>
                    @else
                        <a href="{{ route('dashboard.clients.create') }}" class="btn btn-primary disabled"><i
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

                <th>@lang('site.phone')</th>

                <th>@lang('site.address')</th>

                <th>@lang('site.Add Order')</th>

                <th>@lang('site.action')</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($clients as $client)
                <tr>
                    <td>{{ $loop->index }}</td>
                    <td>{{ $client->name }}</td>
                    <td>{{ implode(',', $client->phone) }}</td>

                    <td>{{ $client->address }}</td>
                    @if (Auth::user()->hasPermission('orders_create'))
                        <td><a href="{{ route('dashboard.clients.orders.create', $client->id) }}"
                                class="btn btn-sm btn-primary">{{ __('site.Add Order') }}</a></td>

                                @else  
                                <td><a href="#"
                                    class="btn btn-sm btn-primary disabled">{{ __('site.Add Order') }}</a></td>
                    @endif


                    @if (Auth::user()->hasPermission('clients_update'))
                        <td><a href="{{ route('dashboard.clients.edit', $client->id) }}"
                                class="btn btn-sm btn-info">@lang('site.edit')</a>
                        @else
                        <td><a href="{{ route('dashboard.clients.edit', $client->id) }}"
                                class="btn btn-sm btn-info disabled">@lang('site.edit')</a>
                    @endif
                    @if (Auth::user()->hasPermission('clients_delete'))
                        <form action="{{ route('dashboard.clients.destroy', $client->id) }}" method="post"
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


    {{ $clients->appends(request()->query())->links() }}













@endsection
