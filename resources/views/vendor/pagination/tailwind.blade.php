@if ($paginator->hasPages())
    <nav class="flex items-center justify-between mt-6 mb-4" role="navigation" aria-label="Pagination">
        {{-- Mobile --}}
        <div class="flex justify-between flex-1 sm:hidden">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="px-5 py-2 text-base text-gray-400 bg-gray-100 border rounded-lg">
                    Previous
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                   class="px-5 py-2 text-base text-gray-700 bg-white border rounded-lg hover:bg-gray-50">
                    Previous
                </a>
            @endif

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                   class="px-5 py-2 ml-3 text-base text-gray-700 bg-white border rounded-lg hover:bg-gray-50">
                    Next
                </a>
            @else
                <span class="px-5 py-2 ml-3 text-base text-gray-400 bg-gray-100 border rounded-lg">
                    Next
                </span>
            @endif
        </div>

        {{-- Desktop --}}
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            {{-- Info --}}
            <div>
                <p class="text-base text-gray-600">
                    Menampilkan
                    <span class="font-semibold">{{ $paginator->firstItem() }}</span>
                    –
                    <span class="font-semibold">{{ $paginator->lastItem() }}</span>
                    dari
                    <span class="font-semibold">{{ $paginator->total() }}</span>
                    data
                </p>
            </div>

            {{-- Links --}}
            <div>
                <span class="inline-flex items-center gap-2">
                    {{-- Previous --}}
                    @if ($paginator->onFirstPage())
                        <span class="px-4 py-2 text-base text-gray-400 bg-gray-100 border rounded-lg">
                            ‹
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}"
                           class="px-4 py-2 text-base text-gray-700 bg-white border rounded-lg hover:bg-gray-50">
                            ‹
                        </a>
                    @endif

                    {{-- Pages --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span class="px-3 py-2 text-base text-gray-400">
                                {{ $element }}
                            </span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span class="px-4 py-2 text-base font-semibold text-white bg-blue-600 rounded-lg">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                       class="px-4 py-2 text-base text-gray-700 bg-white border rounded-lg hover:bg-blue-50 hover:text-blue-600">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}"
                           class="px-4 py-2 text-base text-gray-700 bg-white border rounded-lg hover:bg-gray-50">
                            ›
                        </a>
                    @else
                        <span class="px-4 py-2 text-base text-gray-400 bg-gray-100 border rounded-lg">
                            ›
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
