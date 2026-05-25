@php
    $navLinks = [
        ['label' => 'About', 'href' => '#about'],
        ['label' => 'Programs', 'href' => '#programs'],
        ['label' => 'Impact', 'href' => '#impact'],
        ['label' => 'Partnership', 'href' => '#partnership'],
        ['label' => 'Contact', 'href' => '#contact'],
    ];
@endphp

<header x-data="siteHeader" @keydown.escape.window="mobileOpen = false"
        class="fixed inset-x-0 top-0 z-50 transition-all duration-300"
        :class="scrolled || mobileOpen ? 'bg-white/85 shadow-[0_8px_30px_-12px_rgba(2,27,78,0.18)] backdrop-blur-xl border-b border-navy-100/70' : 'bg-transparent'">
    <nav class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-5 py-4 sm:px-8 lg:py-5"
         aria-label="Primary">
        {{-- Brand --}}
        <a href="#top" class="group flex items-center gap-3" aria-label="Nelo Dreams Foundation — home">
            <span class="h-11 w-11 shrink-0 transition-transform duration-300 group-hover:scale-105">
                <x-logo.nelo />
            </span>
            <span class="flex flex-col leading-tight">
                <span class="font-display text-base font-extrabold tracking-tight transition-colors"
                      :class="scrolled || mobileOpen ? 'text-navy-900' : 'text-white'">Nelo Dreams</span>
                <span class="text-[11px] font-medium uppercase tracking-[0.16em] transition-colors"
                      :class="scrolled || mobileOpen ? 'text-electric-600' : 'text-electric-300'">Foundation Int’l</span>
            </span>
        </a>

        {{-- Desktop nav --}}
        <div class="hidden items-center gap-1 lg:flex">
            @foreach ($navLinks as $link)
                <a href="{{ $link['href'] }}"
                   class="rounded-full px-4 py-2 text-sm font-medium transition-colors"
                   :class="scrolled ? 'text-navy-700 hover:bg-navy-50 hover:text-navy-900' : 'text-white/85 hover:bg-white/10 hover:text-white'">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>

        {{-- Desktop CTAs --}}
        <div class="hidden items-center gap-3 lg:flex">
            <a href="#contact" class="text-sm font-semibold transition-colors"
               :class="scrolled ? 'text-navy-700 hover:text-navy-900' : 'text-white/90 hover:text-white'">
                Volunteer
            </a>
            <x-button href="#contact" size="sm" icon="heart">Donate</x-button>
        </div>

        {{-- Mobile toggle --}}
        <button type="button" @click="mobileOpen = !mobileOpen"
                class="inline-flex h-11 w-11 items-center justify-center rounded-full transition-colors lg:hidden"
                :class="scrolled || mobileOpen ? 'text-navy-900 hover:bg-navy-50' : 'text-white hover:bg-white/10'"
                :aria-expanded="mobileOpen" aria-controls="mobile-menu" aria-label="Toggle navigation">
            <x-icon name="menu" x-show="!mobileOpen" class="h-6 w-6" />
            <x-icon name="close" x-show="mobileOpen" x-cloak class="h-6 w-6" />
        </button>
    </nav>

    {{-- Mobile menu --}}
    <div id="mobile-menu" x-show="mobileOpen" x-collapse x-cloak class="lg:hidden">
        <div class="space-y-1 border-t border-navy-100 bg-white px-5 pb-6 pt-3 sm:px-8">
            @foreach ($navLinks as $link)
                <a href="{{ $link['href'] }}" @click="mobileOpen = false"
                   class="block rounded-2xl px-4 py-3 text-base font-medium text-navy-800 hover:bg-navy-50">
                    {{ $link['label'] }}
                </a>
            @endforeach
            <div class="grid gap-3 pt-3">
                <x-button href="#contact" @click="mobileOpen = false" variant="ghost" icon="hand-raised" class="w-full">Volunteer</x-button>
                <x-button href="#contact" @click="mobileOpen = false" icon="heart" class="w-full">Donate</x-button>
            </div>
        </div>
    </div>
</header>
