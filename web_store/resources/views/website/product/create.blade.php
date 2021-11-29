@role('modify-products')
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
                <form action="{{ route('storeProduct') }}" method="POST" enctype="multipart/form-data">
                    {{-- hidden inputs --}}
                    {{ csrf_field() }}
                    {{-- END hidden inputs --}}
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" name="name" value="{{ old('name') }}" id="name" class="form-control">
                            <label class="form-label">{{ __("website.text_name") }}</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <textarea name="description"  id="email_address" class="form-control no-resize" rows="4">{{ old('description') }}</textarea>
                            <label class="form-label">{{ __("website.text_description") }}</label>
                        </div>
                    </div>
                    <div class="form-group form-float" id="inventories">
                        <label class="card-inside-title">{{ __("website.inventories") }}</label>
                        @foreach ($inventories as $inventory )
                            <div class="form-line focused">
                                <input type="number" oninput="addToQuantity()" name="inventories[{{ $inventory->id }}]" placeholder="                          الكمية داخل المخزن" value='{{ old("inventories.$inventory->id") }}' min="0" id="input-quantity_in_inventory{{ $inventory->id }}" class="form-control">
                                <label class="form-label ">{{ $inventory->name }}</label>
                            </div>
                            <br>
                        @endforeach
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line focused">
                            <input type="number" name="quantity" value="{{ old('quantity') }}" min="0" id="input-quantity" class="form-control" readonly>
                            <label class="form-label ">{{ __("website.text_quantity") }}</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="number" step=".01" name="cost_price" value="{{ old('cost_price') }}" min="0" id="cost_price" class="form-control">
                            <label class="form-label">{{ __("website.text_cost_price") }}</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="number" name="sales_price" step=".01" value="{{ old('sales_price') }}" min="0" id="sales_price" class="form-control">
                            <label class="form-label">{{ __("website.text_sales_price") }}</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line focused">
                            <input type="file" name="image" value="" id="image" class="form-control">
                            <label class="form-label">{{ __("website.text_image") }}</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <label class="card-inside-title">{{ __("website.select_category") }}</label>
                        <select name="category_id" class="form-control show-tick">
                            @foreach ($categories as $category )
                                @if(old('category_id') == $category->id)
                                    <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                @else
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endif                                
                            @endforeach
                            
                        </select>
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