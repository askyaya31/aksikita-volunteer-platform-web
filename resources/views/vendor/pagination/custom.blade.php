@if ($paginator->hasPages())
    <style>
        .ak-pagination {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .ak-page-link,
        .ak-page-current,
        .ak-page-dots {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 34px;
            height: 34px;
            padding: 0 10px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            border: 1.5px solid #e2e8f0;
            color: #475569;
            background: #fff;
            transition: all 0.12s;
        }

        .ak-page-link:hover {
            border-color: #1E3A8A;
            color: #1E3A8A;
        }

        .ak-page-current {
            background: #1E3A8A;
            border-color: #1E3A8A;
            color: #fff;
        }

        .ak-page-disabled {
            color: #cbd5e1;
            border-color: #e2e8f0;
            background: #f8fafc;
            cursor: not-allowed;
        }

        .ak-page-dots {
            border: none;
            background: transparent;
            color: #94a3b8;
        }
    </style>

    <nav class="ak-pagination" role="navigation" aria-label="Pagination">
        @if ($paginator->onFirstPage())
            <span class="ak-page-link ak-page-disabled">&laquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="ak-page-link">&laquo;</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="ak-page-dots">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="ak-page-current">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="ak-page-link">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="ak-page-link">&raquo;</a>
        @else
            <span class="ak-page-link ak-page-disabled">&raquo;</span>
        @endif
    </nav>
@endif