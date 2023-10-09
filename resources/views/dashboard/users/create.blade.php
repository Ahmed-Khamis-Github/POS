@extends('layouts.dashboard.app')
@section('page-title', __('site.Add'))

@section('bread-crumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">{{ __('site.Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('dashboard.users.index') }}">{{ __('site.users') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('site.add') }}</li>
@endsection

@section('content')

    <form action="{{ route('dashboard.users.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('partials._errors')

        <div class="row">

            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>{{ __('site.first_name') }}</label>
                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>{{ __('site.last_name') }}</label>
                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>{{ __('site.email') }}</label>
            <input type="text" name="email" value="{{ old('email') }}" class="form-control">
        </div>

        <div class="form-group">
            <label>{{ __('site.image') }}</label>
            {{-- <input type="file" name="image" class="form-control"> --}}
            <input accept="image/*" name="image" class="form-control" type='file' id="imgInp" />
            <img id="blah" style="width: 100px" src="{{ asset('uploads/users_images/default.jpg') }}" alt="your image" />
        </div>

        {{-- <div class="form-group">
            <img src="{{ asset('uploads/users_images/default.jpg') }}" style="width:100px" class="img-thumbnail"
                alt="">
        </div> --}}

        <div class="row">

            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>{{ __('site.password') }}</label>
                    <input type="password" name="password" class="form-control">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>{{ __('site.password_confirmation') }}</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

            </div>

        </div>

        @php
            $models = ['users', 'categories', 'products', 'clients', 'orders'];
            $maps = ['create', 'read', 'update', 'delete'];
        @endphp
        <div class="card-body">
            <h4>{{ __('site.Permissions') }}</h4>
            <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                @foreach ($models as $index => $model)
                    <li class="nav-item">
                        <a class="nav-link {{ $index == 0 ? 'active' : '' }}" id="custom-content-below-home-tab"
                            data-toggle="pill" href="#custom-content-below-{{ $model }}" role="tab"
                            aria-controls="custom-content-below-{{ $model }}"
                            aria-selected="true">{{ $model }}</a>
                    </li>
                @endforeach

            </ul>
            <div class="tab-content" id="custom-content-below-tabContent">
                @foreach ($models as $index => $model)
                    <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}"
                        id="custom-content-below-{{ $model }}" role="tabpanel"
                        aria-labelledby="custom-content-below-home-tab">
                        @foreach ($maps as $map)
                            <label><input type="checkbox" name="permissions[]" value="{{ $model . '_' . $map }}">
                                @lang('site.' . $map)</label>
                        @endforeach
                    </div>
                @endforeach

            </div>
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
