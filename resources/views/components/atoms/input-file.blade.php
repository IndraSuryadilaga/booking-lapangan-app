@props([
    'disabled' => false,
    'name' => '',
    'id' => null,
    'variant' => 'standard', // 'standard' (untuk bukti bayar) atau 'dropzone' (untuk admin)
    'multiple' => false,
    'accept' => 'image/*',    // Batasan jenis file (cth: 'image/*', 'application/pdf')
    'error' => false,
    'errorMessage' => '',
])

@php
    $id = $id ?? $name ?? uniqid('file-');
    $borderClass = $error
        ? 'border-danger-500 focus-within:border-danger-500 focus-within:ring-danger-500'
        : 'border-neutral-300 dark:border-neutral-700 focus-within:border-primary-500 focus-within:ring-primary-500';
@endphp

<div class="w-full"
     x-data="{
        isDragging: false,
        fileList: [],

        handleFileChange(e) {
            this.updateFileList(e.target.files);
        },
        handleDrop(e) {
            if ({{ $disabled ? 'true' : 'false' }}) return;
            this.updateFileList(e.dataTransfer.files);
            // Sinkronisasikan file drop ke input element asli agar terkirim saat form submit
            this.$refs.fileInput.files = e.dataTransfer.files;
        },
        updateFileList(files) {
            this.fileList = [];
            for (let i = 0; i < files.length; i++) {
                this.fileList.push({
                    name: files[i].name,
                    size: (files[i].size / 1024 / 1024).toFixed(2) + ' MB'
                });
            }
        },
        removeFiles() {
            this.fileList = [];
            this.$refs.fileInput.value = '';
        }
     }"
>
    <input
        type="file"
        name="{{ $multiple ? $name.'[]' : $name }}"
        id="{{ $id }}"
        x-ref="fileInput"
        @change="handleFileChange"
        accept="{{ $accept }}"
        {{ $multiple ? 'multiple' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        class="hidden"
    >

    @if($variant === 'standard')
        <div class="flex items-center w-full shadow-sm rounded-full bg-white dark:bg-neutral-900 border overflow-hidden p-1 {{ $borderClass }}"
             :class="{'opacity-75 bg-neutral-100 dark:bg-neutral-800 cursor-not-allowed': {{ $disabled ? 'true' : 'false' }}}">

            <label
                for="{{ $id }}"
                class="px-5 py-1.5 sm:py-2 rounded-full bg-neutral-900 text-white dark:bg-white dark:text-neutral-900 text-xs sm:text-sm font-bold shadow hover:opacity-90 cursor-pointer transition-all shrink-0 select-none"
                :class="{'cursor-not-allowed opacity-50': {{ $disabled ? 'true' : 'false' }}}"
                @click="if({{ $disabled ? 'true' : 'false' }}) $event.preventDefault()"
            >
                Pilih Berkas
            </label>

            <div class="flex-1 px-4 text-xs sm:text-sm truncate text-neutral-400 dark:text-neutral-500">
                <template x-if="fileList.length === 0">
                    <span>Belum ada berkas dipilih...</span>
                </template>
                <template x-if="fileList.length > 0">
                    <span class="text-neutral-900 dark:text-white font-medium" x-text="fileList[0].name"></span>
                </template>
            </div>

            <template x-if="fileList.length > 0">
                <button
                    type="button"
                    @click="removeFiles()"
                    class="pr-4 text-neutral-400 hover:text-danger-500 focus:outline-none transition-colors"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </template>
        </div>

    @elseif($variant === 'dropzone')
        <div
            @dragover.prevent="if(!{{ $disabled ? 'true' : 'false' }}) isDragging = true"
            @dragleave.prevent="isDragging = false"
            @drop.prevent="isDragging = false; handleDrop($event)"
            class="w-full rounded-2xl border-2 border-dashed p-8 transition-all duration-200 flex flex-col items-center justify-center text-center bg-white dark:bg-neutral-900"
            :class="{
                'border-primary-500 bg-primary-50/30 dark:bg-primary-950/10 scale-[0.99]': isDragging,
                'border-danger-500 bg-danger-50/10': {{ $error ? 'true' : 'false' }},
                'border-neutral-300 dark:border-neutral-700 hover:border-primary-400': !isDragging && !{{ $error ? 'true' : 'false' }},
                'opacity-60 bg-neutral-50 dark:bg-neutral-800 cursor-not-allowed': {{ $disabled ? 'true' : 'false' }}
            }"
        >
            <label for="{{ $id }}" class="flex flex-col items-center justify-center w-full h-full cursor-pointer" :class="{'cursor-not-allowed': {{ $disabled ? 'true' : 'false' }}}">
                <div class="p-3 bg-neutral-100 dark:bg-neutral-800 rounded-full text-neutral-500 dark:text-neutral-400 mb-4 transition-colors" :class="{'bg-primary-100 text-primary-600 dark:bg-primary-900/40 dark:text-primary-400': isDragging}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                </div>

                <p class="text-sm text-neutral-700 dark:text-neutral-300 font-semibold mb-1">
                    <span class="text-primary-500 dark:text-primary-400">Klik untuk unggah</span> atau seret berkas ke sini
                </p>
                <p class="text-xs text-neutral-400 dark:text-neutral-500">
                    {{ $accept === 'image/*' ? 'PNG, JPG, JPEG atau WEBP' : 'Semua berkas yang didukung' }} (Maks. 5MB per berkas)
                </p>
            </label>

            <template x-if="fileList.length > 0">
                <div class="w-full mt-6 pt-4 border-t border-neutral-100 dark:border-neutral-800 text-left space-y-2">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-neutral-400 uppercase tracking-wider" x-text="fileList.length + ' Berkas siap diunggah:'"></span>
                        <button type="button" @click="removeFiles()" class="text-xs font-semibold text-danger-500 hover:underline">Hapus Semua</button>
                    </div>
                    <div class="max-h-40 overflow-y-auto space-y-1.5 pr-1">
                        <template x-for="(file, index) in fileList" :key="index">
                            <div class="flex items-center justify-between text-xs bg-neutral-50 dark:bg-neutral-800/60 border border-neutral-200/60 dark:border-neutral-700/50 px-3 py-2 rounded-xl">
                                <div class="flex items-center gap-2 min-w-0 pr-4">
                                    <svg class="w-4 h-4 text-neutral-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="font-medium text-neutral-700 dark:text-neutral-300 truncate" x-text="file.name"></span>
                                </div>
                                <span class="text-neutral-400 font-medium shrink-0" x-text="file.size"></span>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    @endif

    @if($error && $errorMessage)
        <p class="mt-1.5 text-14 text-danger-500 font-medium">{{ $errorMessage }}</p>
    @endif
</div>
