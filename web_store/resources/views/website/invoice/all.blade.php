@role('show-invoices')
@extends("website.index")
@section("content")
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    {{ __("website.my_invoices") }}
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ url("safe/create") }}">{{ __("website.create") }}</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="table-responsive" >
                    <table class="table table-bordered table-striped table-hover dataTable js-exportable" >
                        <thead>
                            <tr>
                                <th>{{__("ID")}}</th>
                                <th>{{__("website.column_user_name")}}</th>
                                <th>{{__("website.column_invoice_to")}}</th>
                                <th>{{__("website.column_invoice_total")}}</th>
                                <th>{{__("website.column_invoice_subtotal")}}</th>
                                <th>{{__("website.cloumn_action")}}</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>{{__("ID")}}</th>
                                <th>{{__("website.column_user_name")}}</th>
                                <th>{{__("website.column_invoice_to")}}</th>
                                <th>{{__("website.column_invoice_total")}}</th>
                                <th>{{__("website.column_invoice_subtotal")}}</th>
                                <th>{{__("website.cloumn_action")}}</th>
                            </tr>
                        </tfoot>
                        <tbody id="work-table">
                            @include('website.invoice.components.table',['invoices' => $invoices])
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endSection
@endrole