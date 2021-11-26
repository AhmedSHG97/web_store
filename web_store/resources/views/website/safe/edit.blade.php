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
                <form action="{{ route('updateSafe') }}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name = "id" value="{{ $safe->id}}">
                    {{-- hidden inputs --}}
                    {{ csrf_field() }}
                    {{-- END hidden inputs --}}
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" name="name" value="{{ old('name',$safe->name) }}" id="name" class="form-control">
                            <label class="form-label">{{ __("website.text_name") }}</label>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="form-line focused">
                            <input type="number" name="total_amount" value="{{ old('name',$safe->total_amount) }}" id="total_amount" class="form-control">
                            <label class="form-label">{{ __("website.column_total_amount") }}</label>
                        </div>
                    </div>
                    <br>
                    <center><button type="submit" class="btn btn-primary m-t-15 waves-effect ">{{ __("website.button_update") }}</button></center>
                </form>
            </div>
        </div>
    </div>
</div>
@role('show-safe')
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        {{ __("website.my_transactions") }}
                    </h2>
                        <button type="button" class="btn btn-info header-dropdown" data-toggle="modal" data-target="#exampleModal">
                            {{ __('website.text_make_transaction') }}
                        </button>
                </div>
                <div class="body">
                    <div class="table-responsive" >
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable" >
                            <thead>
                                <tr>
                                    <th>{{__("ID")}}</th>
                                    <th>{{__("website.column_user_name")}}</th>
                                    <th>{{__("website.column_safe_name")}}</th>
                                    <th>{{__("website.column_safe_credit")}}</th>
                                    <th>{{__("website.column_transaction_amount")}}</th>
                                    <th>{{__("website.column_transaction_type")}}</th>
                                    <th>{{__("website.column_transaction_time")}}</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>{{__("ID")}}</th>
                                    <th>{{__("website.column_user_name")}}</th>
                                    <th>{{__("website.column_safe_name")}}</th>
                                    <th>{{__("website.column_safe_credit")}}</th>
                                    <th>{{__("website.column_transaction_amount")}}</th>
                                    <th>{{__("website.column_transaction_type")}}</th>
                                    <th>{{__("website.column_transaction_time")}}</th>
                                </tr>
                            </tfoot>
                            <tbody id="work-table">
                                @include('website.safe.components.safe_transactions_table',['safeTransactions' => $safeTransactions])
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('website.text_make_transaction') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('storeTransaction') }}" method="POST" id="transaction-form" enctype="multipart/form-data">
                    <input type="hidden" name = "safe_id" value="{{ $safe->id}}">
                    <input type="hidden" name = "user_id" value="{{ userSession()->id}}">
                    {{-- hidden inputs --}}
                    {{ csrf_field() }}
                    {{-- END hidden inputs --}}
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="number" name="transaction_amount" value="{{ old('transaction_amount') }}" id="transaction_amount" class="form-control">
                            <label class="form-label">{{ __("website.column_transaction_amount") }}</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <label class="card-inside-title">{{ __("website.select_transaction_type") }}</label>
                        <select name="transaction_type" class="form-control show-tick">
                                @if(old('transaction_type') == "withdraw")
                                    <option value="withdraw" selected>{{ __("website.withdraw") }}</option>
                                @else
                                    <option value="withdraw">{{ __("website.withdraw") }}</option>
                                @endif  
                                @if(old('transaction_type') == "deposit")
                                    <option value="deposit" selected>{{ __("website.deposit") }}</option>
                                @else
                                    <option value="deposit">{{ __("website.deposit") }}</option>
                                @endif                               
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("website.close") }}</button>
                <button type="submit" form="transaction-form" class="btn btn-primary">{{ __("website.create") }}</button>
            </div>
            </div>
        </div>
    </div>
    @endrole
        
      
      
@endsection
@endrole