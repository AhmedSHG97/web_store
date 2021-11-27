@extends('website.index')
@section('content')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    {{ $title }}
                </h2>
            </div>
            <div class="body">
                <form action="{{ route('updateSettings') }}" method="POST">
                    {{ csrf_field() }}
                    <input type='hidden' name="id" value="{{ $settings->id }}">
                    <div class="form-group form-float">
                        <div class="form-line focused">
                            <input type="text" name="app_name" value="{{ old('app_name',$settings->app_name) }}" id="name" class="form-control">
                            <label class="form-label">{{ __("website.text_app_name") }}</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line focused">
                            <input type="text" name="app_phone" value="{{ old('app_phone',$settings->app_phone) }}" id="app_phone" class="form-control">
                            <label class="form-label">{{ __("website.text_app_phone") }}</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line focused">
                            <input type="text" name="address" value="{{ old('address',$settings->address) }}" id="address" class="form-control">
                            <label class="form-label">{{ __("website.text_address") }}</label>
                        </div>
                    </div>
                    <br>
                    <center><button type="submit" class="btn btn-primary m-t-15 waves-effect ">{{ __("website.button_update") }}</button></center>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection