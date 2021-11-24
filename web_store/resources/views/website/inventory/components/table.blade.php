@foreach($inventories as $inventory)
    <tr>
        <td>{{ $inventory->id }}</td>
        <td>{{ $inventory->name }}</td>
        <td>{{ $inventory->address }}</td>
        <td>{{ $inventory->credit }}</td>
        <td><img src="{{ url($inventory->image) }}" style="height:100px; width:100px"></td>
        <td>
            @role('modify-inventories')          
            <a href="{{url('/inventory/edit/'. $inventory->id)}}" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ __("website.button_edit") }}"><i class="material-icons">edit</i><span class="icon-name"></span></a>
            <a class="btn btn-danger" onclick='deleteField({{$inventory->id}},"{{url("inventory/delete")}}")'data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ __("website.button_delete") }}"><i class="material-icons">delete</i><span class="icon-name"></span></a>
            @elserole
            {{ __("website.no_actions") }}
            @endrole
        </td> 
    </tr>
@endforeach