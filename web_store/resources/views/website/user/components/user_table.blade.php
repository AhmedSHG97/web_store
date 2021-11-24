@foreach($users as $user)
    <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>
            @role("modify-users")
            <a href="{{url('/user/edit/'. $user->id)}}" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ __("website.button_edit") }}"><i class="material-icons">edit</i><span class="icon-name"></span></a>
            <a class="btn btn-danger" onclick='deleteField({{$user->id}},"{{url("/user/delete")}}")'data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ __("website.button_delete") }}"><i class="material-icons">delete</i><span class="icon-name"></span></a>
            @elserole
            {{ __("website.no_action") }}
            @endrole
        </td> 
    </tr>
@endforeach