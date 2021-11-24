@foreach($permissions as $permission)
<tr>
    @if($user->hasPermission($permission->slug))
    <td>
        <input type="checkbox" name = "allowed[]"  id="basic_checkbox_{{ $permission->id }}" value="{{ $permission->slug }}" checked/>
        <label for="basic_checkbox_{{ $permission->id }}">{{ __("website.allow") }}</label>
    </td>
    @else
    <td>
        <input type="checkbox"  name = "allowed[]" id="basic_checkbox_{{ $permission->id }}" value="{{ $permission->slug }}" />
        <label for="basic_checkbox_{{ $permission->id }}">{{ __("website.allow") }}</label>
    </td>
    @endif
    <td>{{ $permission->id }}</td>
    <td>{{ $permission->name }}</td>
</tr>
@endforeach