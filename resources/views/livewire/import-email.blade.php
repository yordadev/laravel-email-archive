<div class="text-center py-10 px-10">
    <div class="mt-6">
        <form wire:submit="uploadFile" id="upload-file">
            @if(!$file)
                @include('components.file-upload-input')
            @endif
            @if($file)
                @include('components.file-upload-confirmation')
            @endif
            @error('file')
            <div class="py-3">
                <span class="text-red-500">{{ $message }}</span>
            </div>
            @enderror
        </form>

        <div class="py-3 text-right">
            @if(!$file)
                <button wire:click="$dispatch('closeModal', { component: 'import-email' })"
                        class="rounded shadow px-3 py-1 bg-red-500 text-white text-sm">Close Modal
                </button>
            @endif
            @if($file)
                <button wire:click="$dispatch('closeModal', { component: 'import-email' })"
                        class="rounded shadow px-3 py-1 bg-red-500 text-white text-sm">Cancel Upload
                </button>
            @endif
            @if($file)
                <button form="upload-file" class="rounded shadow px-3 py-1 bg-green-500 text-white text-sm">Confirm
                </button>
            @endif
        </div>
    </div>
</div>
