@if ($paginator->hasPages())

    <div class="d-flex flex-stack flex-wrap pt-10">
        <div class="fs-6 fw-semibold text-gray-700">Showing
            @if ($paginator->firstItem())
                {{ $paginator->firstItem() }}
                {!! __('to') !!}
                {{ $paginator->lastItem() }}
            @else
                {{ $paginator->count() }}
            @endif
            {!! __('of') !!}
            <span class="font-medium">{{ $paginator->total() }}</span>
            {!! __('results') !!}
        </div>
        <ul class="pagination">

            @if (!$paginator->onFirstPage())
                <li class="page-item previous">
                    <a href="{{ $paginator->previousPageUrl() }}" class="page-link">
                        <i class="previous"></i>
                    </a>
                </li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item active">
                        <a href="#" class="page-link">{{ $element }}</a>
                    </li>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <a href="javascript:;" class="page-link">{{ $page }}</a>
                            </li>
                        @else
                            <li class="page-item"
                                aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach


            @if ($paginator->hasMorePages())
                <li class="page-item next">
                    <a href="{{ $paginator->nextPageUrl() }}" class="page-link">
                        <i class="next"></i>
                    </a>
                </li>
            @endif

        </ul>
    </div>

@endif
