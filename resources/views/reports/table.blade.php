<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
    <thead>
    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
        <th class="min-w-125px">Code</th>
        <th class="min-w-125px">Name</th>
        <th class="min-w-125px">Notify</th>
        {{--        <th class="min-w-125px">Pressed At</th>--}}
        <th class="min-w-125px">Location</th>
        <th class="min-w-125px">Action</th>
        <th class="min-w-125px">Played</th>
        {{--        <th class="min-w-125px">Respond At</th>--}}
        <th class="min-w-125px">Respond</th>
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
                        <br>
                        <small>Sr: {{ $alert->id }}</small>
                    </div>
                </div>
            </td>
            <td>
                {{ $alert->ecg_code_nme }}
            </td>
            <td>
                {{ empty($alert->sender_name) ? '-' : $alert->sender_name }}
                <br>
                {{ \App\AppHelper\AppHelper::getAppDateAndTime($alert->alarm_triggered_at) }}
            </td>
            {{--            <td>--}}
            {{--                {{ \App\AppHelper\AppHelper::getAppDateAndTime($alert->alarm_triggered_at) }}--}}
            {{--            </td>--}}
            <td>
                {{ $alert->location_nme }}
            </td>
            <td>
                @if(empty($alert->responded_action))

                    @if($alert->played_type == 'sent_to_manager')
                        <span class="badge badge-danger text-capitalize">{{ __('common.'.$alert->played_type) }}</span>
                    @else
                        <span class="badge badge-success text-capitalize">{{ __('common.'.$alert->played_type) }}</span>
                    @endif

                @else
                    @if($alert->responded_action == 'accept')
                        <span class="badge badge-success text-capitalize">{{ $alert->responded_action }}</span>
                    @else
                        <span class="badge badge-danger text-capitalize">{{ $alert->responded_action }}</span>
                    @endif
                @endif

            </td>
            <td>
                {{ empty($alert->played_at_amplifier) ? '-' : \App\AppHelper\AppHelper::getAppDateAndTime($alert->played_at_amplifier) }}

            </td>
            {{--            <td>--}}
            {{--                {{ empty($alert->respond_at) ? '-' : \App\AppHelper\AppHelper::getAppDateAndTime($alert->respond_at) }}--}}
            {{--            </td>--}}
            <td>
                {{ empty($alert->responder_name) ? '-' : $alert->responder_name }}
                <br>
                {{ empty($alert->respond_at) ? '-' : \App\AppHelper\AppHelper::getAppDateAndTime($alert->respond_at) }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $alerts->appends(request()->query())->links() }}
