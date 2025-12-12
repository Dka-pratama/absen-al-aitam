@props([
    'type' => 'info',
    'message' => null,
])

@php
    $map = [
        'success' => [
            'bg' => '#66cdaa',
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
            'bg' => '#FF4463',
            'border' => 'border-yellow-500 dark:border-yellow-700',
            'text' => 'text-yellow-900 dark:text-yellow-100',
            'icon' => 'text-yellow-600',
        ],
        'danger' => [
            'bg' => '#FF4463',
            'border' => 'border-red-500 dark:border-red-700',
            'text' => 'text-[#FF4463]',
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
    class="fixed bottom-4 right-4 z-50 flex h-24 w-3/4 max-w-96 justify-end overflow-hidden rounded-xl bg-white shadow-lg transition duration-300 ease-in-out"
>
    <svg width="16" height="96" xmlns="http://www.w3.org/2000/svg">
        <path
            d="M 8 0
               Q 4 4.8, 8 9.6
               T 8 19.2
               Q 4 24, 8 28.8
               T 8 38.4
               Q 4 43.2, 8 48
               T 8 57.6
               Q 4 62.4, 8 67.2
               T 8 76.8
               Q 4 81.6, 8 86.4
               T 8 96
               L 0 96
               L 0 0
               Z"
            fill="{{ $c['bg'] }}"
            stroke="{{ $c['bg'] }}"
            stroke-width="2"
            stroke-linecap="round"
        ></path>
    </svg>
    <div class="mx-2.5 w-full overflow-hidden">
        <p
            class="{{ $c['text'] }} mr-3 mt-1.5 overflow-hidden text-ellipsis whitespace-nowrap text-xl font-bold leading-8"
        >
            {{ $type }}
        </p>
        <p class="max-h-10 overflow-hidden break-all leading-5 text-zinc-600">
            {{ $slot->isEmpty() ? $message : $slot }}
        </p>
    </div>
</div>
