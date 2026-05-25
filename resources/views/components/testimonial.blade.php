@props([
    'name',
    'role' => null,
    'organization' => null,
    'quote' => '',
])

<figure {{ $attributes->merge(['class' => 'surface flex h-full flex-col gap-6 p-8']) }}>
    <x-icon name="quote" class="h-9 w-9 text-electric-300" />
    <blockquote class="flex-1 text-lg leading-relaxed text-navy-800">
        {{ $quote ?: $slot }}
    </blockquote>
    <figcaption class="flex items-center gap-4 border-t border-navy-100 pt-5">
        <span class="flex h-12 w-12 items-center justify-center rounded-full bg-navy-900 font-display text-lg font-bold text-electric-300">
            {{ \Illuminate\Support\Str::of($name)->explode(' ')->map(fn ($w) => mb_substr($w, 0, 1))->take(2)->implode('') }}
        </span>
        <div>
            <div class="font-semibold text-navy-900">{{ $name }}</div>
            <div class="text-sm text-navy-500">
                {{ collect([$role, $organization])->filter()->implode(' · ') }}
            </div>
        </div>
    </figcaption>
</figure>
