<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
    <thead>
    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
        <th class="min-w-125px">Location</th>
        <th class="min-w-125px">Room</th>
        <th class="min-w-125px">Floor</th>
        <th class="min-w-125px">Building</th>
        <th class="text-end min-w-70px">Actions</th>
    </tr>
    </thead>
    <tbody class="fw-semibold text-black-600">
    @foreach($locations as $location)
        <tr>
            <td>
                {{ $location->loc_nme }}
            </td>
            <td>
                {{ $location->room }}
            </td>
            <td>
                {{ $location->floor }}
            </td>
            <td>
                {{ $location->building_nme }}
            </td>
            <td class="text-end">
                <a href="#"
                   class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                   data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                    <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                <div
                    class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                    data-kt-menu="true">
                    <div class="menu-item px-3">
                        <a href="{{ route('locations.show', ['location'=> $location->id, 'json'=> 1]) }}"
                           class="menu-link px-3 edit-link">Edit</a>
                    </div>
                    <div class="menu-item px-3">
                        <a href="{{ route('delete_model', ['model' => 'location', 'ref'=> $location->id]) }}"
                           class="menu-link px-3 delete-link"
                           data-kt-customer-table-filter="delete_row">Delete</a>
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $locations->links() }}
