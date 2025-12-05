@props([
    'type' => 'info',
    'message' => null,
])

@php
    $map = [
        'success' => [
            'bg' => 'bg-green-100 dark:bg-green-900',
            'border' => 'border-green-500 dark:border-green-700',
            'text' => 'text-green-900 dark:text-green-100',
            'icon' => 'text-green-600',
        ],
        'info' => [
            'bg' => 'bg-blue-100 dark:bg-blue-900',
            'border' => 'border-blue-500 dark:border-blue-700',
            'text' => 'text-blue-900 dark:text-blue-100',
            'icon' => 'text-blue-600',
        ],
        'warning' => [
            'bg' => 'bg-yellow-100 dark:bg-yellow-900',
            'border' => 'border-yellow-500 dark:border-yellow-700',
            'text' => 'text-yellow-900 dark:text-yellow-100',
            'icon' => 'text-yellow-600',
        ],
        'danger' => [
            'bg' => 'bg-red-100 dark:bg-red-900',
            'border' => 'border-red-500 dark:border-red-700',
            'text' => 'text-red-900 dark:text-red-100',
            'icon' => 'text-red-600',
        ],
    ];

    $c = $map[$type] ?? $map['info'];
@endphp

<div
    x-data="{ show: true }"
    x-init="setTimeout(() => (show = false), 3000)"
    x-show="show"
    x-transition.opacity.duration.500ms
    role="alert"
    class="{{ $c['bg'] }} {{ $c['border'] }} {{ $c['text'] }} fixed right-4 top-4 z-[9999] flex w-72 items-center rounded-lg border-l-4 p-3 shadow-xl transition duration-300 ease-in-out"
>
    <svg
        stroke="currentColor"
        viewBox="0 0 24 24"
        fill="none"
        class="{{ $c['icon'] }} mr-2 h-5 w-5 flex-shrink-0"
        xmlns="http://www.w3.org/2000/svg"
    >
        <path
            d="M13 16h-1v-4h1m0-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
            stroke-width="2"
            stroke-linejoin="round"
            stroke-linecap="round"
        ></path>
    </svg>

    <p class="flex-1 text-xs font-semibold">
        {{ $slot->isEmpty() ? $message : $slot }}
    </p>

    <button @click="show = false" class="ml-2 text-lg leading-none opacity-60 hover:opacity-100">&times;</button>
</div>
