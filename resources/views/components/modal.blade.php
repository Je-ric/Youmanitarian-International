<dialog {{ $attributes->merge(['class' => 'modal']) }}>
    <div class="modal-box w-full max-w-lg p-0 overflow-hidden rounded-xl bg-white border border-slate-200 shadow-xl">
        <!-- Modal Header -->
        <header class="flex items-center justify-between px-6 py-4 border-b border-slate-200 bg-slate-50">
            <div class="flex-1">
                {{ $header ?? '' }}
            </div>
            <x-x-button />
        </header>

        <!-- Modal Body -->
        <div class="p-6">
            {{ $slot }}
        </div>

        <!-- Modal Footer -->
        @isset($footer)
            <footer class="border-t border-slate-200 px-6 py-4 bg-slate-50 flex justify-end gap-2">
                {{ $footer }}
            </footer>
        @endisset
    </div>
</dialog> 