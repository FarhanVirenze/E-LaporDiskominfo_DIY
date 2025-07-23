@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-white text-start text-base font-medium text-black dark:text-white bg-white dark:bg-gray-900/50 focus:outline-none focus:text-black dark:focus:text-white focus:bg-gray-100 dark:focus:bg-gray-900 focus:border-white transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-black dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-white focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:bg-gray-50 dark:focus:bg-gray-700 focus:border-white transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>