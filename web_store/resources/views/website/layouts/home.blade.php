@extends("website.index")
@section("content")
<div class="container-fluid">
    <div class="block-header">
        <h2>{{ $title }}</h2>
    </div>
    @role('show-statistics')
    <!-- Widgets -->
    <div class="row clearfix">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-cyan hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">attach_money</i>
                </div>
                <div class="content">
                    <div class="text">مجموع سعر البيع للفواتير</div>
                    <div class="number count-to" data-from="0" data-to="{{ $invoices_total }}" data-speed="1000" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-cyan hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">attach_money</i>
                </div>
                <div class="content">
                    <div class="text">مجموع سعر التكلفة للفواتير</div>
                    <div class="number count-to" data-from="0" data-to="{{ $invoices_subtotal }}" data-speed="1000" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-cyan hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">attach_money</i>
                </div>
                <div class="content">
                    <div class="text">صافي الربح</div>
                    <div class="number count-to" data-from="0" data-to="{{ $invoices_total - $invoices_subtotal }}" data-speed="1000" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-cyan hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">attach_money</i>
                </div>
                <div class="content">
                    <div class="text">مجموع سعر البيع لكل المنتجات</div>
                    <div class="number count-to" data-from="0" data-to="{{ $productsTotalSalesPrice  }}" data-speed="1000" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-cyan hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">attach_money</i>
                </div>
                <div class="content">
                    <div class="text">مجموع سعر التكلفة لكل المنتجات</div>
                    <div class="number count-to" data-from="0" data-to="{{ $productsTotalCostPrice }}" data-speed="1000" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-cyan hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">attach_money</i>
                </div>
                <div class="content">
                    <div class="text">صافي الربح المتوقع</div>
                    <div class="number count-to" data-from="0" data-to="{{ $productsTotalSalesPrice - $productsTotalCostPrice }}" data-speed="1000" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
        @foreach ( $inventories as $inventory )
        <a href = "{{ url('inventory/edit/'.$inventory->id) }}">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-blue hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">store</i>
                    </div>
                    <div class="content">
                        <div class="text">{{ $inventory->name }}</div>
                        <div class="number count-to" data-from="0" data-to="{{ $inventory->credit }}" data-speed="1000" data-fresh-interval="20"></div>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
        @foreach ( $safes as $safe )
        <a href = "{{ url('safe/edit/'.$safe->id) }}">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-green hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">lock</i>
                        </div>
                        <div class="content">
                            <div class="text">{{ $safe->name }}</div>
                            <div class="number count-to" data-from="0" data-to="{{ $safe->total_amount }}" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
    <!-- #END# Widgets -->
    @endrole
    @role('show-users')
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        {{ __("website.title_users") }}
                    </h2>
                </div>
                <div class="body">
                    <div class="table-responsive" >
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable" >
                            <thead>
                                <tr>
                                    <th>{{__("ID")}}</th>
                                    <th>{{__("website.column_name")}}</th>
                                    <th>{{__("website.column_email")}}</th>
                                    <th>{{__("website.cloumn_action")}}</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>{{__("ID")}}</th>
                                    <th>{{__("website.column_name")}}</th>
                                    <th>{{__("website.column_email")}}</th>
                                    <th>{{__("website.cloumn_action")}}</th>
                                </tr>
                            </tfoot>
                            <tbody id="work-table">
                                @include('website.user.components.user_table',['users'=> $users])
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endrole

</div>
@endsection