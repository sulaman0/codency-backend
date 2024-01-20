<table class="table align-middle table-row-dashed fs-6 gy-5 td-black-color"
       id="kt_customers_table">
    <thead>
    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
        <th class="min-w-125px">Code</th>
        <th class="min-w-125px">Name</th>
        <th class="min-w-125px">Status</th>
        <th class="min-w-125px">Operation</th>
        <th class="min-w-125px">Notify By</th>
        <th class="min-w-125px">Sent To</th>
        <th class="text-end min-w-70px">Actions</th>
    </tr>
    </thead>
    <tbody class="fw-semibold text-black-600">
    @foreach($ecg_codes as $ecgCode)
        <tr>
            <td>
                <div class="d-flex align-items-center">
                    <a href="{{ route('ecg-codes.show', $ecgCode->id) }}" class="symbol symbol-50px">
                                                <span class="badge badge-primary"
                                                      style="background-color: {{ $ecgCode->color_code }}">&nbsp;</span>
                    </a>
                    <div class="ms-5">
                        <!--begin::Title-->
                        <a href="{{ route('ecg-codes.show', $ecgCode->id) }}"
                           class=" fs-5 fw-bold text-primary"
                           data-kt-ecommerce-product-filter="product_name">{{ $ecgCode->code() }}</a>
                    </div>
                </div>
            </td>
            <td>
                {{ $ecgCode->name }}
            </td>
            <td>
                @if($ecgCode->status == "active")
                    <div class="badge badge-light-success">Active</div>
                @else
                    <div class="badge badge-light-danger">Disabled</div>
                @endif
            </td>
            <td>
                {{ $ecgCode->action() }}
            </td>
            <td>{{ $ecgCode->notifyBy() }}</td>
            <td>
                <div class="symbol-group symbol-hover mb-3">
                    @include('user_icons_in_table', ['array' => $ecgCode->assignedToUsers(),
                        'viewAllLink' => route('staff.index', ['ecg_code' => $ecgCode->id])
                    ])
                </div>
            </td>
            <td class="text-end">
                <a href="#"
                   class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                   data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                    <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                <!--begin::Menu-->
                <div
                    class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                    data-kt-menu="true">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="{{ route('ecg-codes.show', $ecgCode->id) }}"
                           class="menu-link px-3">View</a>
                    </div>
                    <div class="menu-item px-3">
                        <a href="{{ route('ecg-codes.edit', $ecgCode->id) }}" class="menu-link px-3"
                           data-kt-customer-table-filter="delete_row">Edit</a>
                    </div>
                    <div class="menu-item px-3">
                        <a href="{{ route('delete_model', ['model' => 'ecgCode', 'ref'=> $ecgCode->id, 'status'  => $ecgCode->status == 'active']) }}"
                           class="menu-link px-3 delete-link">
                            @if($ecgCode->status == 'active')
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
{{ $ecg_codes->appends(request()->query())->links() }}
