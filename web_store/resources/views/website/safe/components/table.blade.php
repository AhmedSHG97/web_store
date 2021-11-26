@foreach($safes as $safe)
    <tr class="text-center" >
        <td>{{ $safe->id }}</td>
        <td>{{ $safe->name }}</td>
        <td>{{ $safe->total_amount }}</td>
        <td>
            @role('modify-safe')          
            <a href="{{url('/safe/edit/'. $safe->id)}}" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ __("website.button_edit") }}"><i class="material-icons">edit</i><span class="icon-name"></span></a>
            <a class="btn btn-danger" onclick='deleteField({{$safe->id}},"{{url("safe/delete")}}")'data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ __("website.button_delete") }}"><i class="material-icons">delete</i><span class="icon-name"></span></a>
            @elserole
            {{ __("website.no_actions") }}
            @endrole
        </td> 
    </tr>
@endforeach