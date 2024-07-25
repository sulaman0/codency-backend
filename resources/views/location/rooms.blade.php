<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
    <thead>
    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
        <th class="min-w-125px">Room</th>
        <th class="min-w-125px">Floor</th>
        <th class="min-w-125px">Building</th>
        <th class="min-w-125px">Status</th>
        <th class="min-w-125px">Sync Status</th>
        <th class="text-end min-w-70px">Actions</th>
    </tr>
    </thead>
    <tbody class="fw-semibold text-black-600">
    @foreach($locations as $location)
        <tr>
            <td>
                {{ $location->room_nme }}
            </td>
            <td>
                {{ $location->floorNme() }}
            </td>
            <td>
                {{ $location->buildingNme() }}
            </td>
            <td>
                @if($location->status == "active")
                    <div class="badge badge-light-success">Active</div>
                @else
                    <div class="badge badge-light-danger">In-Active</div>
                @endif
            </td>
            <td>
                @if($location->audio_status == "synced")
                    <div class="badge badge-light-success">Synced</div>
                @else
                    <div class="badge badge-light-danger">Syncing</div>
                @endif
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
                        <a href="{{ route('locations.show', ['location'=> $location->id, 'loc_type' => 'room', 'json'=> 1]) }}"
                           loc-type="room"
                           class="menu-link px-3 edit-link">Edit</a>
                    </div>
                    <div class="menu-item px-3">
                        <a href="{{ route('delete_model', ['model' => 'location', 'type' => 'room', 'ref'=> $location->id, 'status'  => $location->status == 'active']) }}"
                           class="menu-link px-3 delete-link"
                           reload-link="{{ route('location_table', ['location_type' => 'rooms']) }}"
                           data-kt-customer-table-filter="delete_row">
                            @if($location->status == 'active')
                                In-Active
                            @else
                                Active
                            @endif
                        </a>
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<a href="{{ route('location_table', ['location_type'=> 'floors']) }}"
   class="location-details fs-5 text-primary mt-5 d-flex">
    <i class="ki-duotone ki-black-left fs-2 text-primary"></i> &nbsp;Go Back
</a>
{{  $locations->appends(request()->query())->links() }}
