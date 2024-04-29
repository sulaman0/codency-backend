<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
    <thead>
    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
        <th class="min-w-125px">Name</th>
        <th class="min-w-125px">Designation</th>
        <th class="min-w-125px">Group</th>
        <th class="min-w-125px">Status</th>
        <th class="min-w-125px">Email</th>
        <th class="min-w-125px">Phone</th>
        <th class="text-end min-w-70px">Actions</th>
    </tr>
    </thead>
    <tbody class="fw-semibold text-black-600">
    @foreach($users as $user)
        <tr>
            <td>
                <a href="{{ route('staff.show', $user->id ) }}"
                   class="location-details fs-5 text-primary">
                    {{ $user->name }}
                </a>
            </td>
            <td>
                {{ $user->designation }}
            </td>
            <td>
                <div class="symbol-group symbol-hover mb-3">
                    @include('user_icons_in_table', ['array' => $user->groupArray()])
                </div>
            </td>
            <td>
                @if($user->status == "active")
                    <div class="badge badge-light-success">Active</div>
                @else
                    <div class="badge badge-light-danger">Blocked</div>
                @endif
            </td>
            <td>
                <a href="mailto:{{ $user->email }}" class="text-gray-600 text-hover-primary mb-1">{{ $user->email }}</a>
            </td>
            <td>{{ \App\AppHelper\AppHelper::getPhoneNumberFormated($user->phone) }}</td>
            <td class="text-end">
                <a href="#"
                   class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                   data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                    <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                <div
                        class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                        data-kt-menu="true">
                    <div class="menu-item px-3">
                        <a href="{{ route('staff.show', $user->id) }}"
                           class="menu-link px-3">View</a>
                    </div>
                    <div class="menu-item px-3">
                        <a href="{{ route('staff.show', ['staff' => $user->id, 'json' => 1]) }}"
                           class="edit-link menu-link px-3">Edit</a>
                    </div>
                    <div class="menu-item px-3">
                        <a href="{{ route('delete_model', ['model' => 'user', 'ref'=> $user->id, 'status'  => $user->status == 'active']) }}"
                           class="menu-link px-3 delete-link">
                            @if($user->status == 'active')
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
{{ $users->appends(request()->query())->links() }}
