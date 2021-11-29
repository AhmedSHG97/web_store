@role('modify-safe')
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
                <form action="{{ route('storeSafe') }}" method="POST" enctype="multipart/form-data">
                    {{-- hidden inputs --}}
                    {{ csrf_field() }}
                    {{-- END hidden inputs --}}
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" name="name" value="{{ old('name') }}" id="name" class="form-control">
                            <label class="form-label">{{ __("website.text_name") }}</label>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="form-line focused">
                            <input type="number" name="total_amount" step=".01" value="{{ old('total_amount') }}" id="total_amount" class="form-control">
                            <label class="form-label">{{ __("website.column_total_amount") }}</label>
                        </div>
                    </div>
                    <br>
                    <center><button type="submit" class="btn btn-primary m-t-15 waves-effect ">{{ __("website.create") }}</button></center>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@endrole