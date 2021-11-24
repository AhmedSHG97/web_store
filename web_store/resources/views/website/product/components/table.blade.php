@foreach($products as $product)
    <tr>
        <td>{{ $product->id }}</td>
        <td>{{ $product->name }}</td>
        @if($product->quantity > 30)
        <td class=" btn-success">{{ $product->quantity }}</td>
        @elseif($product->quantity < 30 && $product->quantity > 10)
        <td class=" btn-warning">{{ $product->quantity }}</td>
        @elseif($product->quantity < 10)
        <td class=" btn-danger">{{ $product->quantity }}</td>
        @endif
        @if(count($product->inventories) > 0)
        <td>
            <select name="category_id" class="form-control ">
                @foreach ($product->inventories as $inventory )
                <option value="{{ $inventory->id }}">{{ $inventory->name }}</option>
                @endforeach
                
            </select>
        </td>
        @else
        <td> {{ __("website.no_stores") }} </td>
        
        @endif
        <td> {{ $product->category->name }} </td>
        <td><img src="{{ url($product->image) }}" style="height:100px; width:100px"></td>
        <td>
            @role('modify-products')          
            <a href="{{url('/product/edit/'. $product->id)}}" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ __("website.button_edit") }}"><i class="material-icons">edit</i><span class="icon-name"></span></a>
            <a class="btn btn-danger" onclick='deleteField({{$product->id}},"{{url("product/delete")}}")'data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ __("website.button_delete") }}"><i class="material-icons">delete</i><span class="icon-name"></span></a>
            @elserole
            {{ __("website.no_actions") }}
            @endrole
        </td> 
    </tr>
@endforeach