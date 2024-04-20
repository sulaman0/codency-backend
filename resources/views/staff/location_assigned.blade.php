<table class="table align-middle table-row-dashed gy-5"
       id="kt_table_customers_payment">
    <thead class="border-bottom border-gray-200 fs-7 fw-bold">
    <tr class="text-start text-muted text-uppercase gs-0">
        <th class="min-w-100px">Building Name</th>
        <th class="min-w-100px">Floor Name</th>
        <th class="min-w-100px">Room Name</th>
        <th class="min-w-100px">Assigned At</th>
    </tr>
    </thead>
    <tbody class="fs-6 fw-semibold text-black-600">
    @foreach($userLocation as $location)
        <tr>
            <td>
                {{  $location->buildingName() }}
            </td>
            <td>
                {{ $location->FloorName() }}
            </td>
            <td>
                {{ $location->roomName() }}
            </td>
            <td>{{ \App\AppHelper\AppHelper::getAppDateAndTime($location->created_at) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $userLocation->appends(request()->query())->links() }}

