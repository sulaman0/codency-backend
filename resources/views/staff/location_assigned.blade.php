@php use App\Models\Locations\RoomModel;use App\Models\Users\UserLocationModel; @endphp
<style>
    .locationBox {
        border: 1px solid black;
        padding: 10px;
        flex: 1 0 21%;
        margin: 5px;
    }

    .assignedLocation {
        background-color: var(--bs-primary) !important;
        color: white;
        flex: 1 0 21%;
        margin: 5px;
        padding: 10px;
    }
</style>
@foreach($allLocations as $locations)
    <h4 class="bg-primary text-white p-4">{{ $locations->buildingNme() }}</h4>
    <div style="display: flex;  flex-wrap: wrap;">
        @foreach(RoomModel::where('building_id', $locations->building_id)->get() as $location)
            <div
                class="cursor-pointer user-location-block @if(UserLocationModel::checkLocationIsAssigned($user_id, $location->id)) assignedLocation  @else locationBox @endif"
                data-href="{{ route('location_assign_to_user', ['userId' => $user_id,'locationId' => $location->id])}}">
                <p>{{ $location->floorNme() }}</p>
                <p>{{ $location->room_nme }}</p>
            </div>
        @endforeach
    </div>
@endforeach

