{{-- The single confirmation dialog shared by every destructive action in the
     admin panel. Driven by the `confirmDialog` Alpine store in app.js. --}}
<div x-data
     x-show="$store.confirmDialog.open"
     x-cloak
     {{-- Holds the wrapper on screen while the backdrop and panel animate out. --}}
     x-transition:leave="transition-opacity duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-100"
     @keydown.escape.window="$store.confirmDialog.cancel()"
     class="fixed inset-0 z-[100] flex items-end justify-center p-4 sm:items-center"
     role="dialog"
     aria-modal="true"
     aria-labelledby="confirm-dialog-title">

    {{-- Backdrop --}}
    <div x-show="$store.confirmDialog.open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="$store.confirmDialog.cancel()"
         class="absolute inset-0 bg-navy-950/60 backdrop-blur-sm"
         aria-hidden="true"></div>

    {{-- Panel --}}
    <div x-show="$store.confirmDialog.open"
         x-effect="$store.confirmDialog.open && $nextTick(() => $refs.confirmButton?.focus())"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95 sm:translate-y-0"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95 sm:translate-y-0"
         class="surface relative w-full max-w-md p-6 sm:p-7">

        <div class="flex gap-4">
            <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-rose-50 text-rose-600">
                <x-icon name="warning" class="h-5 w-5" />
            </span>

            <div class="min-w-0 flex-1">
                <h2 id="confirm-dialog-title" class="font-display text-lg font-bold text-navy-900"
                    x-text="$store.confirmDialog.title"></h2>
                <p class="mt-1.5 text-sm leading-relaxed text-navy-500"
                   x-show="$store.confirmDialog.message"
                   x-text="$store.confirmDialog.message"></p>
            </div>
        </div>

        <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <button type="button" @click="$store.confirmDialog.cancel()" class="admin-btn-ghost">
                Cancel
            </button>

            <button type="button" x-ref="confirmButton" @click="$store.confirmDialog.confirm()"
                    class="inline-flex items-center justify-center gap-2 rounded-full bg-rose-600 px-5 py-2.5 text-sm
                           font-semibold text-white shadow-sm transition hover:bg-rose-700 focus:outline-none
                           focus-visible:ring-2 focus-visible:ring-rose-400 focus-visible:ring-offset-2"
                    x-text="$store.confirmDialog.confirmLabel"></button>
        </div>
    </div>
</div>
