@props(['name', 'type' => 'text', 'label', 'value' => '', 'required' => false])

<div class="relative mt-2" x-data="{ focused: {{ $value ? 'true' : 'false' }}, hasValue: {{ $value ? 'true' : 'false' }} }">
    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        @focus="focused = true"
        @blur="focused = $el.value !== ''; hasValue = $el.value !== ''"
        @input="hasValue = $el.value !== ''"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'peer block w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent placeholder-transparent transition']) }}
        placeholder="{{ $label }}"
    >
    <label
        for="{{ $name }}"
        class="absolute left-3 -top-2.5 text-xs text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-700 px-1 transition-all duration-200 ease-in-out origin-top-left pointer-events-none"
        :class="{'-top-2.5 text-xs': focused || hasValue, 'top-2.5 text-sm': !focused && !hasValue, 'text-brand-primary dark:text-indigo-300': focused }"
    >
        {{ $label }} {{ $required ? '*' : '' }}
    </label>
     @error($name)
        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div> 