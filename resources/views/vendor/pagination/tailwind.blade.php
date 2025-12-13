@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex flex-col gap-4 mb-2">

        {{-- Mobile --}}
        <div class="flex items-center justify-between sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="px-4 py-2 text-sm rounded-lg bg-gray-100 text-gray-400 dark:bg-gray-800">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 text-sm rounded-lg bg-white border hover:bg-gray-100 dark:bg-gray-900 dark:border-gray-700">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 text-sm rounded-lg bg-white border hover:bg-gray-100 dark:bg-gray-900 dark:border-gray-700">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="px-4 py-2 text-sm rounded-lg bg-gray-100 text-gray-400 dark:bg-gray-800">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        {{-- Desktop --}}
        <div class="hidden sm:flex items-center justify-between gap-6">

            {{-- Info --}}
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Showing <span class="font-medium">{{ $paginator->firstItem() }}</span>
                – <span class="font-medium">{{ $paginator->lastItem() }}</span>
                of <span class="font-medium">{{ $paginator->total() }}</span>
            </p>

            {{-- Pagination --}}
            <div class="flex items-center gap-1">

                {{-- Prev --}}
                @if ($paginator->onFirstPage())
                    <span class="p-2 rounded-lg bg-gray-100 text-gray-400 dark:bg-gray-800">
                        ‹
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="p-2 rounded-lg border bg-white hover:bg-gray-100 dark:bg-gray-900 dark:border-gray-700">
                        ‹
                    </a>
                @endif

                {{-- Pages --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="px-3 py-2 text-sm text-gray-400">…</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="px-4 py-2 text-sm rounded-lg bg-blue-600 text-white font-medium">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="px-4 py-2 text-sm rounded-lg border bg-white hover:bg-blue-50 dark:bg-gray-900 dark:border-gray-700">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="p-2 rounded-lg border bg-white hover:bg-gray-100 dark:bg-gray-900 dark:border-gray-700">
                        ›
                    </a>
                @else
                    <span class="p-2 rounded-lg bg-gray-100 text-gray-400 dark:bg-gray-800">
                        ›
                    </span>
                @endif

            </div>
        </div>
    </nav>
@endif