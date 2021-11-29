@role('modify-invoices')
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
                <form action="{{ route('storeInvoice') }}" method="POST" enctype="multipart/form-data">
                    {{-- hidden inputs --}}
                    {{ csrf_field() }}
                    {{-- END hidden inputs --}}
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" name="invoice_to" value="{{ old('invoice_to') }}" id="invoice_to" class="form-control">
                            <label class="form-label">{{ __("website.text_invoice_to") }}</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" name="invoice_owner_address" value="{{ old('invoice_owner_address') }}" id="invoice_owner_address" class="form-control">
                            <label class="form-label">{{ __("website.text_invoice_owner_address") }}</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" name="invoice_owner_phone" value="{{ old('invoice_owner_phone') }}" id="invoice_owner_phone" class="form-control">
                            <label class="form-label">{{ __("website.text_invoice_owner_phone") }}</label>
                        </div>
                    </div>
                    <br>
                    <center><button type="submit" class="btn btn-primary m-t-15 waves-effect ">{{ __("website.create") }}</button></center>
                </form>
            </div>
        </div>
    </div>
</div>
@role('modify-invoices')
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        {{ __("website.my_products") }}
                    </h2>
                    <button type="button" class="btn btn-info header-dropdown hidden"  id="invoicePriceModel" data-toggle="modal" data-target="#invoiceExampleModal">
                        {{ __('website.text_make_transaction') }}
                    </button>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="{{ url("product/create") }}">{{ __("website.create") }}</a></li>
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
                                    <th>{{__("website.add_products")}}</th>
                                    <th>{{__("website.column_name")}}</th>
                                    <th>{{__("website.column_cost_price")}}</th>
                                    <th>{{__("website.column_sale_price")}}</th>
                                    <th>{{__("website.column_quantity")}}</th>
                                    <th>{{__("website.column_inventories")}}</th>
                                    <th>{{__("website.column_category")}}</th>
                                    <th>{{__("website.column_image")}}</th>
                                    <th>{{__("website.cloumn_action")}}</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>{{__("ID")}}</th>
                                    <th>{{__("website.add_products")}}</th>
                                    <th>{{__("website.column_name")}}</th>
                                    <th>{{__("website.column_cost_price")}}</th>
                                    <th>{{__("website.column_sale_price")}}</th>
                                    <th>{{__("website.column_quantity")}}</th>
                                    <th>{{__("website.column_inventories")}}</th>
                                    <th>{{__("website.column_category")}}</th>
                                    <th>{{__("website.column_image")}}</th>
                                    <th>{{__("website.cloumn_action")}}</th>
                                </tr>
                            </tfoot>
                            <tbody id="work-table">
                                @include('website.invoice.components.invoice_products_table',['products' => $products])
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="invoiceExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('website.text_make_transaction') }}</h5>
                <button type="button" id="closeModal" class="close hidden" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <input type="hidden" id="productId" name = "product_id" value="">
                    <input type="hidden" id="userId" name = "user_id" value="{{ userSession()->id}}">
                    <input type="hidden" id="total_quantity" name = "total_quantity" value="">
                    <div class="form-group form-float">
                        <div class="form-line focused">
                            <input type="number" name="sales_price" value="{{ old('sales_price') }}" step=".01" id="sales_price" class="form-control">
                            <label class="form-label">{{ __("website.column_sale_price") }}</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line focused">
                            <input type="number" name="quantity"  value="{{ old('quantity') }}" id="quantity" class="form-control">
                            <label class="form-label">{{ __("website.column_quantity") }}</label>
                        </div>
                    </div>
                    <div class="form-group" id="product_inventories">
                        <label class="card-inside-title">{{ __("website.select_inventory") }}</label>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="clearInputs()" class="btn btn-secondary" data-dismiss="modal">{{ __("website.close") }}</button>
                <button type="button"  onclick='updateInvoiceProducts("{{route("storeInvoiceProducts")}}",null,null,true)' class="btn btn-primary">{{ __("website.add") }}</button>
            </div>
            </div>
        </div>
    </div>
    @endrole
@endsection

@endrole