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
                <form action="{{ route('updateUser') }}" method="POST">
                    {{ csrf_field() }}
                    <input type='hidden' name="id" value="{{ $user->id }}">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" name="name" value="{{ old('name',$user->name) }}" id="name" class="form-control">
                            <label class="form-label">{{ __("auth.text_name") }}</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="email" name="email" value="{{ old('email',$user->email) }}" id="email_address" class="form-control">
                            <label class="form-label">{{ __("auth.text_email") }}</label>
                        </div>
                    </div>
                    <br>
                    <center><button type="submit" class="btn btn-primary m-t-15 waves-effect ">{{ __("website.button_update") }}</button></center>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    {{ __("website.user_permissions") }}
                </h2>
                <button type="submit" class="btn btn-info header-dropdown" form="update-permissions">{{ __("website.button_update") }}</button>
            </div>
            <div class="body">
                <div class="table-responsive" >
                    <form method="post" action="{{ route('updateUserPermissions') }}" id="update-permissions">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $user->id }}">
                    <table class="table table-bordered table-striped table-hover dataTable js-exportable" >
                        <thead>
                            <tr>
                                <th>{{__("website.allowed_permissions")}}</th>
                                <th>{{__("ID")}}</th>
                                <th>{{__("website.column_name")}}</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>{{__("website.check")}}</th>
                                <th>{{__("ID")}}</th>
                                <th>{{__("website.column_name")}}</th>
                            </tr>
                        </tfoot>
                            <tbody id="work-table">
                                @include('website.permission.components.table')
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection