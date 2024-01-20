@if(!empty($array))
    @php $count = 5; @endphp
    @if(count($array) < 5)
        @php $count = count($array); @endphp
    @endif

    @for($x=0; $x < $count; $x++)
        <div class="symbol symbol-35px symbol-circle"
             data-bs-toggle="tooltip"
             data-bs-original-title="{{$array[$x]['name']}}" data-kt-initialized="1">
                <span class="symbol-label bg-warning text-inverse-warning fw-bold">
                    {{ substr($array[$x]['name'], 0, 1) }}
                </span>
        </div>
    @endfor

    @if(!empty($viewAllLink))
        <div class="symbol symbol-35px symbol-circle"
             data-bs-toggle="tooltip"
             data-bs-original-title="View All" data-kt-initialized="1">
            <a href="{{ $viewAllLink }}">
            <span class="symbol-label bg-primary text-inverse-warning fw-bold">
                All
            </span>
            </a>
        </div>
    @endif
@endif
