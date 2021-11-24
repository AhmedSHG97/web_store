@foreach($categories as $category)
    <tr>
        <td>{{ $category->id }}</td>
        <td>{{ $category->name }}</td>
        <td><img src="{{ url($category->image) }}" style="height:100px; width:100px"></td>
        <td>
            @role('modify-categories')          
            <a href="{{url('/category/edit/'. $category->id)}}" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ __("website.button_edit") }}"><i class="material-icons">edit</i><span class="icon-name"></span></a>
            <a class="btn btn-danger" onclick='deleteField({{$category->id}},"{{url("category/delete")}}")'data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ __("website.button_delete") }}"><i class="material-icons">delete</i><span class="icon-name"></span></a>
            @elserole
            {{ __("website.no_actions") }}
            @endrole
        </td> 
    </tr>
@endforeach