<div>
    @if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="pagination-navigation">
        <span>
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
            <button wire:click="nextPage" wire:loading.attr="disabled" rel="next" disabled class="disapled">
                {!! __('pagination.previous') !!}
            </button>
            @else
            <button wire:click="previousPage" wire:loading.attr="disabled" rel="prev">
                {!! __('pagination.previous') !!}
            </button>
            @endif
        </span>

        @foreach ($elements as $element)
        <div class="pagination-numbers">
            @if (is_array($element))
            @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
            <li class="mintCream" wire:click="gotoPage({{$page}})">{{$page}}</li>
            @else
            <li wire:click="gotoPage({{$page}})">{{$page}}</li>
            @endif
            @endforeach
            @endif
        </div>
        @endforeach

        <span>
            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
            <button wire:click="nextPage" wire:loading.attr="disabled" rel="next">
                {!! __('pagination.next') !!}
            </button>
            @else
            <button wire:click="nextPage" wire:loading.attr="disabled" rel="next" disabled class="disapled">
                {!! __('pagination.next') !!}
            </button>
            @endif
        </span>
    </nav>
    @endif
</div>