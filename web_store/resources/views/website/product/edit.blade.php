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
                <form action="{{ route('updateProduct') }}" method="POST" enctype="multipart/form-data">
                    {{-- hidden inputs --}}
                    <input type="hidden" name="id" value="{{ $product->id }}">
                    {{ csrf_field() }}
                    {{-- END hidden inputs --}}
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" name="name" value="{{ old('name',$product->name) }}" id="name" class="form-control">
                            <label class="form-label">{{ __("website.text_name") }}</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <textarea name="description"  id="email_address" class="form-control no-resize" rows="4">{{ old('description',$product->description) }}</textarea>
                            <label class="form-label">{{ __("website.text_description") }}</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="number" name="quantity" value="{{ old('quantity',$product->quantity) }}" min="0" id="quantity" class="form-control">
                            <label class="form-label">{{ __("website.text_quantity") }}</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="number" name="cost_price" value="{{ old('cost_price',$product->cost_price) }}" min="0" id="cost_price" class="form-control">
                            <label class="form-label">{{ __("website.text_cost_price") }}</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="number" name="sales_price" value="{{ old('sales_price',$product->sales_price) }}" min="0" id="sales_price" class="form-control">
                            <label class="form-label">{{ __("website.text_sales_price") }}</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line focused">
                            <input type="file" name="image" value="" id="image" class="form-control">
                            <label class="form-label">{{ __("website.text_image") }}</label>
                        </div>
                        <img src="{{ url($product->image) }}" style="height:100px; width:100px" >
                    </div>
                    <div class="form-group form-float">
                        <label class="card-inside-title">{{ __("website.categories") }}</label>
                        <select name="category_id" class="form-control show-tick">
                            @foreach ($categories as $category )
                                @if( old('category_id',$product->category_id)  == $category->id)
                                    <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                @else
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endif                                
                            @endforeach
                            
                        </select>
                    </div>
                    <div class="form-group form-float">
                        <label class="card-inside-title">{{ __("website.inventories") }}</label>
                        @foreach ($inventories as $inventory )
                            @if( in_array($inventory->id , old('inventories',$product->inventories_ids)) )
                                <input type="checkbox" name="inventories[]" id="basic_checkbox_{{ $inventory->id }}" value="{{ $inventory->id }}" class="filled-in" checked />
                                <label for="basic_checkbox_{{ $inventory->id }}">{{ $inventory->name }}</label>
                                <br>
                            @else
                                <input type="checkbox" name="inventories[]" id="basic_checkbox_{{ $inventory->id }}" value="{{ $inventory->id }}" class="filled-in"  />
                                    <label for="basic_checkbox_{{ $inventory->id }}">{{ $inventory->name }}</label>
                                    <br>
                                @endif
                        @endforeach
                    </div>
                    <br>
                    <center><button type="submit" class="btn btn-primary m-t-15 waves-effect ">{{ __("website.button_update") }}</button></center>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@endrole