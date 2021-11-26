@role('modify-inventories')
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
                <form action="{{ route('updateInventory') }}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name = "id" value="{{ $inventory->id}}">
                    {{-- hidden inputs --}}
                    {{ csrf_field() }}
                    {{-- END hidden inputs --}}
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" name="name" value="{{ old('name',$inventory->name) }}" id="name" class="form-control">
                            <label class="form-label">{{ __("website.text_name") }}</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" name="address" value="{{ old('address',$inventory->address) }}" id="email_address" class="form-control">
                            <label class="form-label">{{ __("website.text_address") }}</label>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="form-line focused">
                            <input type="file" name="image" value="" id="image" class="form-control">
                            <label class="form-label">{{ __("website.text_image") }}</label>
                        </div>
                        <img src="{{ url($inventory->image) }}" style = "height:100px; width:100px;">
                    </div>
                    <br>
                    <center><button type="submit" class="btn btn-primary m-t-15 waves-effect ">{{ __("website.button_update") }}</button></center>
                </form>
            </div>
        </div>
    </div>
</div>
    @role('show-products')
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        {{ __("website.my_products") }}
                    </h2>
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
                                    <th>{{__("website.column_name")}}</th>
                                    <th>{{__("website.column_cost_price")}}</th>
                                    <th>{{__("website.column_sale_price")}}</th>
                                    <th>{{__("website.column_quantity")}}</th>
                                    <th>{{__("website.column_inventories")}}</th>
                                    <th>{{__("website.column_image")}}</th>
                                    <th>{{__("website.column_category")}}</th>
                                    <th>{{__("website.cloumn_action")}}</th>
                                </tr>
                            </tfoot>
                            <tbody id="work-table">
                                @include('website.product.components.table',['products' => $products])
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endrole
@endsection
@endrole