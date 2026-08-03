@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}">

        <div class="flex gap-2 items-center justify-between sm:hidden">

            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-[#706f6c] dark:text-[#A1A09A] bg-white dark:bg-[#161615] border border-[#19140035] dark:border-[#3E3E3A] cursor-not-allowed leading-5 rounded-lg">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-4 py-2 text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] bg-white dark:bg-[#161615] border border-[#19140035] dark:border-[#3E3E3A] leading-5 rounded-lg hover:border-[#1915014a] dark:hover:border-[#62605b] focus:outline-none focus:ring-2 focus:ring-[#f53003]/25 dark:focus:ring-[#FF4433]/25 transition ease-in-out duration-150">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-4 py-2 text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] bg-white dark:bg-[#161615] border border-[#19140035] dark:border-[#3E3E3A] leading-5 rounded-lg hover:border-[#1915014a] dark:hover:border-[#62605b] focus:outline-none focus:ring-2 focus:ring-[#f53003]/25 dark:focus:ring-[#FF4433]/25 transition ease-in-out duration-150">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-[#706f6c] dark:text-[#A1A09A] bg-white dark:bg-[#161615] border border-[#19140035] dark:border-[#3E3E3A] cursor-not-allowed leading-5 rounded-lg">
                    {!! __('pagination.next') !!}
                </span>
            @endif

        </div>

        <div class="hidden sm:flex-1 sm:flex sm:gap-2 sm:items-center sm:justify-between">

            <div>
                <p class="text-sm text-[#706f6c] dark:text-[#A1A09A] leading-5">
                    {!! __('Showing') !!}
                    @if ($paginator->firstItem())
                        <span class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ $paginator->firstItem() }}</span>
                        {!! __('to') !!}
                        <span class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    {!! __('of') !!}
                    <span class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>

            <div>
                <span class="inline-flex gap-1.5 rtl:flex-row-reverse">

                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="inline-flex items-center justify-center w-9 h-9 text-sm font-medium text-[#706f6c] dark:text-[#A1A09A] bg-white dark:bg-[#161615] border border-[#19140035] dark:border-[#3E3E3A] cursor-not-allowed rounded-lg leading-5 opacity-50" aria-hidden="true">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center justify-center w-9 h-9 text-sm font-medium text-[#706f6c] dark:text-[#A1A09A] bg-white dark:bg-[#161615] border border-[#19140035] dark:border-[#3E3E3A] rounded-lg leading-5 hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] hover:border-[#1915014a] dark:hover:border-[#62605b] focus:outline-none focus:ring-2 focus:ring-[#f53003]/25 dark:focus:ring-[#FF4433]/25 transition ease-in-out duration-150" aria-label="{{ __('pagination.previous') }}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="inline-flex items-center justify-center w-9 h-9 text-sm font-medium text-[#706f6c] dark:text-[#A1A09A] bg-white dark:bg-[#161615] border border-[#19140035] dark:border-[#3E3E3A] cursor-default rounded-lg leading-5">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="inline-flex items-center justify-center w-9 h-9 text-sm font-semibold text-white dark:text-[#1b1b18] bg-[#1b1b18] dark:bg-[#EDEDEC] border border-[#1b1b18] dark:border-[#EDEDEC] cursor-default rounded-lg leading-5">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="inline-flex items-center justify-center w-9 h-9 text-sm font-medium text-[#706f6c] dark:text-[#A1A09A] bg-white dark:bg-[#161615] border border-[#19140035] dark:border-[#3E3E3A] rounded-lg leading-5 hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] hover:border-[#1915014a] dark:hover:border-[#62605b] focus:outline-none focus:ring-2 focus:ring-[#f53003]/25 dark:focus:ring-[#FF4433]/25 transition ease-in-out duration-150" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center justify-center w-9 h-9 text-sm font-medium text-[#706f6c] dark:text-[#A1A09A] bg-white dark:bg-[#161615] border border-[#19140035] dark:border-[#3E3E3A] rounded-lg leading-5 hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] hover:border-[#1915014a] dark:hover:border-[#62605b] focus:outline-none focus:ring-2 focus:ring-[#f53003]/25 dark:focus:ring-[#FF4433]/25 transition ease-in-out duration-150" aria-label="{{ __('pagination.next') }}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="inline-flex items-center justify-center w-9 h-9 text-sm font-medium text-[#706f6c] dark:text-[#A1A09A] bg-white dark:bg-[#161615] border border-[#19140035] dark:border-[#3E3E3A] cursor-not-allowed rounded-lg leading-5 opacity-50" aria-hidden="true">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
