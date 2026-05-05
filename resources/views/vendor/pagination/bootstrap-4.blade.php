@if ($paginator->hasPages())
<div class="d-flex justify-content-between align-items-center">
    <div class="text-muted small">
        Showing
        <strong>{{ $paginator->firstItem() }}</strong>
        to
        <strong>{{ $paginator->lastItem() }}</strong>
        of
        <strong>{{ $paginator->total() }}</strong> entries
    </div>
    <nav>
        <ul class="pagination justify-content-end mb-0">
            @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link">Previous</span></li>
            @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}">Previous</a>
            </li>
            @endif
            @foreach ($elements as $element)
            @if (is_string($element))
            <li class="page-item disabled">
                <span class="page-link">{{ $element }}</span>
            </li>
            @endif
            @if (is_array($element))
            @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
            <li class="page-item active">
                <span class="page-link">{{ $page }}</span>
            </li>
            @else
            <li class="page-item">
                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
            </li>
            @endif
            @endforeach
            @endif
            @endforeach
            @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}">Next</a>
            </li>
            @else
            <li class="page-item disabled"><span class="page-link">Next</span></li>
            @endif
        </ul>
    </nav>
</div>
@endif