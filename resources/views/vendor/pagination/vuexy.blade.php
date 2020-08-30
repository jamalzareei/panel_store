<style>
    #DataTables_Table_0_paginate{display: none;}
</style>
<div class="dataTables_wrapper">
<div class="dataTables_paginate paging_simple_numbers">
@if ($paginator->hasPages())
    <nav>
        {{-- <li class="paginate_button page-item ">
            <a href="#" aria-controls="DataTables_Table_0" data-dt-idx="2" tabindex="0" class="page-link">2</a>
        </li>
        <li class="paginate_button page-item ">
            <a class="page-link" href="http://localhost/shixeh/admin/properties?page=2">2</a>
        </li> --}}
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="paginate_button page-item  disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">&lsaquo;قبلی</span>
                </li>
            @else
                <li class="paginate_button page-item ">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;قبلی</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="paginate_button page-item  disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="paginate_button page-item  active" aria-current="page"><span class="page-link font-small-2">{{ $page }}</span></li>
                        @else
                            <li class="paginate_button page-item "><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="paginate_button page-item ">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">بعدی&rsaquo;</a>
                </li>
            @else
                <li class="paginate_button page-item  disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">بعدی&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
</div>
</div>