@props(['name', 'label', 'accept' => '*/*', 'required' => false])

<div class="mt-2"
    x-data="fileUpload_{{ Str::slug($name) }}()"
    x-init="init()">
    <label for="{{ $name }}" class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">
        {{ $label }} {{ $required ? '*' : '' }}
    </label>
    <div class="relative flex items-center justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-md"
         :class="{ 'border-indigo-400 dark:border-indigo-500': dragging }"
         @dragover.prevent="dragging = true"
         @dragleave.prevent="dragging = false"
         @drop.prevent="handleDrop($event)">

        <div class="space-y-1 text-center">
             <svg class="mx-auto h-10 w-10 text-gray-400 dark:text-gray-500" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
             </svg>
            <div class="flex text-sm text-gray-600 dark:text-gray-400">
                <label for="{{ $name }}" class="relative cursor-pointer bg-white dark:bg-gray-700 rounded-md font-medium text-brand-primary hover:text-brand-secondary focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-brand-primary px-1">
                    <span>Upload a file</span>
                    <input id="{{ $name }}" name="{{ $name }}" type="file" class="sr-only" accept="{{ $accept }}" {{ $required && !$slots->has('preview') ? 'required' : '' }} @change="handleFileSelect($event)">
                </label>
                <p class="pl-1">or drag and drop</p>
            </div>
             <p class="text-xs text-gray-500 dark:text-gray-500">{{ $attributes->get('info', 'PDF, PNG, JPG up to 2MB') }}</p>
         </div>
    </div>

    {{-- Preview & Progress Area --}}
    <div x-show="fileName" class="mt-3 text-sm" style="display: none;">
        <div class="flex items-center justify-between bg-gray-100 dark:bg-gray-700 p-2 rounded-md">
            <span class="truncate text-gray-700 dark:text-gray-200" x-text="fileName"></span>
             <button type="button" @click="removeFile()" class="ml-2 text-red-500 hover:text-red-700 focus:outline-none">
                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
             </button>
         </div>
         {{-- Progress Bar --}}
         <div x-show="progress > 0 && progress < 100" class="mt-1 w-full bg-gray-200 dark:bg-gray-600 rounded-full h-1.5" style="display: none;">
            <div class="bg-brand-primary h-1.5 rounded-full" :style="{ width: progress + '%' }"></div>
         </div>
    </div>
     @error($name)
        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror

    {{-- Slot for existing file preview if needed --}}
     @if ($slot->isNotEmpty())
         <div class="mt-3 text-sm">
             {{ $slot }}
         </div>
     @endif
</div>

<script>
    function fileUpload_{{ Str::slug($name) }}() {
        return {
            dragging: false,
            fileName: '',
            progress: 0,
            fileInput: null,
            init() {
                this.fileInput = this.$refs.input; // Assuming you add ref="input" to the file input if needed elsewhere
            },
            handleFileSelect(event) {
                const file = event.target.files[0];
                if (file) {
                    this.fileName = file.name;
                    this.uploadFile(file); // Simulate upload
                }
            },
            handleDrop(event) {
                this.dragging = false;
                const file = event.dataTransfer.files[0];
                if (file) {
                    // Manually set the file input's files property
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    document.getElementById('{{ $name }}').files = dataTransfer.files;

                    this.fileName = file.name;
                    this.uploadFile(file); // Simulate upload
                }
            },
            removeFile() {
                this.fileName = '';
                this.progress = 0;
                document.getElementById('{{ $name }}').value = null; // Clear the file input
            },
             // Basic simulation - replace with actual AJAX upload logic
            uploadFile(file) {
                 this.progress = 0;
                 let interval = setInterval(() => {
                     this.progress += 10;
                     if (this.progress >= 100) {
                         clearInterval(interval);
                         this.progress = 100; // Ensure it hits 100
                         // Optionally reset progress: setTimeout(() => this.progress = 0, 1000);
                     }
                 }, 100);
            }
        }
    }
</script> 