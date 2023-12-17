<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
    <thead>
    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
        <th class="min-w-125px">Code</th>
        <th class="min-w-125px">Name</th>
        <th class="min-w-125px">Pressed At</th>
        <th class="min-w-125px">Location</th>
        <th class="min-w-125px">Played At Amplifier</th>
        <th class="min-w-125px">Notify By</th>
        <th class="min-w-125px">Respond At</th>
        <th class="min-w-125px">Respond By</th>
    </tr>
    </thead>
    <tbody class="fw-semibold text-black-600">
    @foreach($alerts as $alert)
        <tr>
            <td>
                <div class="d-flex align-items-center">
                    <a href="{{ route('ecg-codes.show', [ 'ecg_code' => $alert->ecg_code_id]) }}"
                       class="symbol symbol-50px">
                                            <span class="badge badge-primary"
                                                  style="background-color: {{ $alert->color_code }}">&nbsp;</span>
                    </a>
                    <div class="ms-5">
                        <a href="{{ route('ecg-codes.show', [ 'ecg_code' => $alert->ecg_code_id]) }}"
                           class="text-primary fs-5 fw-bold">{{ $alert->code }}</a>
                    </div>
                </div>
            </td>
            <td>
                {{ $alert->ecg_code_nme }}
            </td>
            <td>
                {{ \App\AppHelper\AppHelper::getAppDateAndTime($alert->alarm_triggered_at) }}
            </td>
            <td>
                {{ $alert->location_nme }}
            </td>
            <td>
                {{ empty($alert->played_at_amplifier) ? '-' : \App\AppHelper\AppHelper::getAppDateAndTime($alert->played_at_amplifier) }}
            </td>
            <td>
                {{ empty($alert->name) ? '-' : $alert->name }}
            </td>
            <td>
                {{ empty($alert->respond_at) ? '-' : \App\AppHelper\AppHelper::getAppDateAndTime($alert->respond_at) }}
            </td>
            <td>
                {{ empty($alert->respond_by) ? '-' : $alert->respond_by }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $alerts->links() }}
