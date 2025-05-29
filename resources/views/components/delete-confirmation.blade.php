@props([
    'id' => 'confirm-dialog',
    'formId' => null,
    'show' => false,
    'title' => 'Confirm Action',
    'message' => '',
    'confirmText' => 'Delete',
    'cancelText' => 'Cancel'
])

@push('scripts')
<script>
    function toggleConfirmDialog(id, show) {
        const dialog = document.getElementById(id);
        if (!dialog) return;
        if (show) {
        dialog.showModal();
        } else {
        dialog.close();
        }
    }

  // Close dialog on Escape key (for accessibility)
  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      document.querySelectorAll('dialog[open]').forEach(dialog => dialog.close());
    }
  });
</script>
@endpush

<dialog
    id="{{ $id }}"
    class="w-full max-w-lg rounded-2xl bg-white p-6 relative shadow-lg outline-none"
    {{-- No inline display:none; rely on dialog behavior --}}
    @if($show)
        x-init="() => $nextTick(() => document.getElementById('{{ $id }}').showModal())"
    @endif
    role="dialog"
    aria-modal="true"
    aria-labelledby="{{ $id }}-title"
    aria-describedby="{{ $id }}-message"
>
    <x-x-button
      aria-label="Close confirmation dialog"
        onclick="document.getElementById('{{ $id }}').close()">
    </x-x-button>

    {{-- Title --}}
    <h2 id="{{ $id }}-title" class="text-left font-poppins text-2xl font-bold text-[#d13434] leading-tight mb-4">
        {{ $title }}
    </h2>

    {{-- Divider --}}
    <hr class="border-neutral-300 mb-6">



    {{-- Message --}}
    <p id="{{ $id }}-message" class="text-center text-zinc-600 font-poppins text-lg leading-relaxed mb-8 px-4 whitespace-pre-line">
        {!! e($message) !!}
    </p>

    {{-- Buttons --}}
    <div class="flex justify-center gap-6 flex-wrap px-4">
        <button
            type="button"
            onclick="document.getElementById('{{ $id }}').close()"
            class="w-40 py-3 rounded-lg border border-stone-300 text-black/80 font-poppins font-medium hover:bg-stone-100 transition"
        >
            {{ $cancelText }}
        </button>

        @if($formId)
            <button
                type="submit"
                form="{{ $formId }}"
                class="w-40 py-3 rounded-lg bg-red-600 text-white font-poppins font-bold shadow-md hover:bg-red-700 transition"
            >
                {{ $confirmText }}
            </button>
        @else
            <button
                type="button"
                onclick="document.getElementById('{{ $id }}').close()"
                class="w-40 py-3 rounded-lg bg-red-600 text-white font-poppins font-bold shadow-md hover:bg-red-700 transition"
            >
                {{ $confirmText }}
            </button>
        @endif
    </div>
</dialog>
