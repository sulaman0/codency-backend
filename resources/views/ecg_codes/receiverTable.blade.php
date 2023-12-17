<table class="table align-middle table-row-dashed gy-5"
       id="kt_table_customers_payment">
    <thead class="border-bottom border-gray-200 fs-7 fw-bold">
    <tr class="text-start text-muted text-uppercase gs-0">
        <th class="min-w-100px">Emergency Code</th>
        <th>Designation</th>
        <th class="min-w-100px">Assigned At</th>
    </tr>
    </thead>
    <tbody class="fs-6 fw-semibold text-black-600">
    @foreach($receiverTable as $sender)
        <tr>
            <td>
                {{  $sender['name'] }}
            </td>
            <td>
                {{ $sender['designation'] }}
            </td>
            <td>{{ \App\AppHelper\AppHelper::getAppDateAndTime($sender['created_at']) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $receiverTable->links() }}

