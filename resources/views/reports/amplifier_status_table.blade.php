<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
    <thead>
    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
        <th class="min-w-125px">Device Id</th>
        <th class="min-w-125px">Battery Health</th>
        <th class="min-w-125px">Created At</th>
    </tr>
    </thead>
    <tbody class="fw-semibold text-black-600">
    @foreach($updates as $alert)
        <tr>
            <td>
                {{ $alert->device_id }}
            </td>
            <td>
                {{ $alert->battery_health }}
            </td>
            <td>
                {{ \App\AppHelper\AppHelper::getAppDateAndTime($alert->created_at) }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{--{{ $updates->links() }}--}}
