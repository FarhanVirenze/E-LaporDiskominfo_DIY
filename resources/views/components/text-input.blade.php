@props(['disabled' => false])

<input @disabled($disabled) 
    {{ $attributes->merge(['class' => 'focus:border-red-500 dark:focus:border-red-600 focus:ring-red-500 dark:focus:ring-red-600 rounded-md shadow-sm']) }}>
