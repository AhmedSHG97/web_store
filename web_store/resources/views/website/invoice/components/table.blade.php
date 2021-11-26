@foreach($invoices as $invoice)
    <tr class="text-center" >
        <td>{{ $invoice->id }}</td>
        <td>{{ $invoice->user->name }}</td>
        <td>{{ $invoice->invoice_to }}</td>
        <td>{{ $invoice->total }}</td>
        <td>{{ $invoice->subtotal }}</td>
        <td>
            @role('modify-invoices')          
            <a class="btn btn-danger" onclick='deleteField({{$invoice->id}},"{{url("invoice/delete")}}")' data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ __("website.button_delete") }}"><i class="material-icons">delete</i><span class="icon-name"></span></a>
            <a class="btn btn-info" href="{{ url("invoice/print/".$invoice->id) }}"  data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ __("website.button_print") }}"><i class="material-icons">print</i><span class="icon-name"></span></a>
            @elserole
            {{ __("website.no_actions") }}
            @endrole
        </td> 
    </tr>
@endforeach