<table class="table align-middle table-row-dashed gy-5"
       id="kt_table_customers_payment">
    <thead class="border-bottom border-gray-200 fs-7 fw-bold">
    <tr class="text-start text-muted text-uppercase gs-0">
        <th class="min-w-100px">Emergency Code</th>
        <th>Action</th>
        <th class="min-w-100px">Assigned At</th>
    </tr>
    </thead>
    <tbody class="fs-6 fw-semibold text-black-600">
    @foreach($receiverTable as $ecgCode)
        <tr>
            <td>
                <a class="text-primary"
                   href="{{ route('ecg-codes.show', ['ecg_code' => $ecgCode->id]) }}">{{  $ecgCode->ecg_code_nme }}</a>
            </td>
            <td>
                @if($ecgCode->respond_by_id == $ecgCode->id)
                    Responded
                @endif
                @if($ecgCode->alarm_triggered_by_id == $ecgCode->id)
                    Sender
                @endif
            </td>
            <td>{{ \App\AppHelper\AppHelper::getAppDateAndTime($ecgCode->created_at) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $receiverTable->appends(request()->query())->links() }}

