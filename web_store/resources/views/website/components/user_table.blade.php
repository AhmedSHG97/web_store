@foreach($users as $user)
    <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>
            <a class="btn btn-info"><i class="material-icons">edit</i><span class="icon-name">{{ __("website.button_edit") }}</span></a>
            <a class="btn btn-danger" onclick='deleteUser("{{ $user->id }}")'><i class="material-icons">delete</i><span class="icon-name">{{ __("website.button_delete") }}</span></a>
        </td> 
    </tr>
@endforeach