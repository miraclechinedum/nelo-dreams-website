@props([
    'title' => 'Are you sure?',
    'message' => '',
    'confirmLabel' => 'Delete',
    'form' => null,        // id of a form elsewhere on the page, when the button can't be nested inside it
])

{{-- A real submit button that asks first via the shared confirmation modal.
     Without JavaScript it still submits, exactly like any other submit button. --}}
<button type="submit"
        @if ($form) form="{{ $form }}" @endif
        @click.prevent="$store.confirmDialog.ask($el.form, {
            title: @js($title),
            message: @js($message),
            confirmLabel: @js($confirmLabel),
        })"
        {{ $attributes }}>
    {{ $slot }}
</button>
