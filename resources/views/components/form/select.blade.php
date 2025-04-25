@props(['name', 'label', 'options', 'selected' => null, 'required' => false])

<div class="relative mt-2">
     <label for="{{ $name }}" class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">
        {{ $label }} {{ $required ? '*' : '' }}
    </label>
    <select
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'block w-full pl-3 pr-10 py-2.5 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent sm:text-sm transition']) }}
    >
        <option value="" disabled {{ is_null($selected) ? 'selected' : '' }}>Select {{ $label }}...</option>
        @foreach($options as $value => $display)
            <option value="{{ $value }}" {{ old($name, $selected) == $value ? 'selected' : '' }}>
                {{ $display }}
            </option>
        @endforeach
    </select>
    <div class="pointer-events-none absolute inset-y-0 right-0 top-6 flex items-center px-2 text-gray-700 dark:text-gray-300">
        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
    </div>
     @error($name)
        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div> 