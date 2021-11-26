@foreach($safeTransactions as $transaction)
    <tr class="text-center" >
        <td>{{ $transaction->id }}</td>
        <td>{{ $transaction->user->name }}</td>
        <td>{{ $transaction->safe->name }}</td>
        <td>{{ $transaction->safe_credit }}</td>
        <td>{{ $transaction->transaction_amount }}</td>
        @if($transaction->transaction_type == "withdraw")
        <td class="btn-danger">{{ __("website.withdraw") }}</td>
        @elseif($transaction->transaction_type == "deposit")
        <td class="btn-success">{{ __("website.deposit") }}</td>
        @endif
        <td>{{ $transaction->created_at }}</td>
    </tr>
@endforeach