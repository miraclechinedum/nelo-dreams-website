@php
    $contactEmail = 'rangersintlfcfoundation@gmail.com';
    $interests = ['Partner', 'Donate', 'Volunteer', 'General'];
@endphp

<section id="contact" class="relative overflow-hidden bg-navy-50/60 py-24 lg:py-32">
    <div class="mx-auto max-w-7xl px-5 sm:px-8">
        <div class="grid gap-12 lg:grid-cols-12 lg:gap-16">
            {{-- Left — info + map --}}
            <div class="lg:col-span-5">
                <x-reveal>
                    <x-section-header eyebrow="Get In Touch" title="Let’s Build It Together">
                        Whether you want to partner, donate, volunteer, or bring a program to your school — we’d love to hear from you.
                    </x-section-header>
                </x-reveal>

                <x-reveal :delay="100">
                    <div class="mt-8 space-y-4">
                        <a href="mailto:{{ $contactEmail }}" class="group flex items-center gap-4 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-navy-100 transition-all hover:-translate-y-0.5 hover:shadow-md">
                            <span class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-electric-50 text-electric-600 group-hover:bg-electric-500 group-hover:text-white">
                                <x-icon name="envelope" class="h-6 w-6" />
                            </span>
                            <span class="min-w-0">
                                <span class="block text-xs font-semibold uppercase tracking-wider text-navy-400">Email</span>
                                <span class="block truncate font-semibold text-navy-900">{{ $contactEmail }}</span>
                            </span>
                        </a>
                        <div class="flex items-center gap-4 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-navy-100">
                            <span class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-electric-50 text-electric-600">
                                <x-icon name="map-pin" class="h-6 w-6" />
                            </span>
                            <span>
                                <span class="block text-xs font-semibold uppercase tracking-wider text-navy-400">Location</span>
                                <span class="block font-semibold text-navy-900">Enugu, Nigeria</span>
                            </span>
                        </div>
                    </div>
                </x-reveal>

                {{-- Map --}}
                <x-reveal :delay="160">
                    <div class="mt-6 overflow-hidden rounded-2xl bg-navy-100/50 shadow-sm ring-1 ring-navy-100">
                        <iframe
                            title="Map showing Enugu, Nigeria"
                            src="https://www.google.com/maps?q=Enugu,+Nigeria&output=embed"
                            class="h-64 w-full border-0 grayscale-[20%]"
                            loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </x-reveal>
            </div>

            {{-- Right — form --}}
            <div class="lg:col-span-7">
                <x-reveal :delay="80">
                    <div class="surface p-7 sm:p-10">
                        @if (session('contact_success'))
                            <div class="mb-6 flex items-start gap-3 rounded-2xl bg-electric-50 p-4 text-electric-800" role="status">
                                <x-icon name="check-circle" class="mt-0.5 h-5 w-5 shrink-0 text-electric-600" />
                                <p class="text-sm font-medium">{{ session('contact_success') }}</p>
                            </div>
                        @endif

                        <form action="{{ route('contact.store') }}" method="POST" class="space-y-5" novalidate>
                            @csrf

                            {{-- Honeypot (hidden from humans) --}}
                            <div class="hidden" aria-hidden="true">
                                <label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label>
                            </div>

                            <div class="grid gap-5 sm:grid-cols-2">
                                <div>
                                    <label for="name" class="mb-1.5 block text-sm font-semibold text-navy-800">Name <span class="text-electric-600">*</span></label>
                                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autocomplete="name"
                                        class="w-full rounded-xl border-navy-200 bg-white px-4 py-3 text-navy-900 shadow-sm transition focus:border-electric-500 focus:ring-2 focus:ring-electric-500/30 @error('name') border-red-400 @enderror"
                                        @error('name') aria-invalid="true" aria-describedby="name-error" @enderror />
                                    @error('name')<p id="name-error" class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label for="email" class="mb-1.5 block text-sm font-semibold text-navy-800">Email <span class="text-electric-600">*</span></label>
                                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email"
                                        class="w-full rounded-xl border-navy-200 bg-white px-4 py-3 text-navy-900 shadow-sm transition focus:border-electric-500 focus:ring-2 focus:ring-electric-500/30 @error('email') border-red-400 @enderror"
                                        @error('email') aria-invalid="true" aria-describedby="email-error" @enderror />
                                    @error('email')<p id="email-error" class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label for="phone" class="mb-1.5 block text-sm font-semibold text-navy-800">Phone</label>
                                    <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" autocomplete="tel"
                                        class="w-full rounded-xl border-navy-200 bg-white px-4 py-3 text-navy-900 shadow-sm transition focus:border-electric-500 focus:ring-2 focus:ring-electric-500/30 @error('phone') border-red-400 @enderror" />
                                    @error('phone')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label for="interest" class="mb-1.5 block text-sm font-semibold text-navy-800">I’m interested in</label>
                                    <select id="interest" name="interest"
                                        class="w-full rounded-xl border-navy-200 bg-white px-4 py-3 text-navy-900 shadow-sm transition focus:border-electric-500 focus:ring-2 focus:ring-electric-500/30">
                                        @foreach ($interests as $interest)
                                            <option value="{{ $interest }}" @selected(old('interest') === $interest)>
                                                {{ $interest === 'General' ? 'General enquiry' : ($interest === 'Partner' ? 'Partnering with us' : ($interest === 'Donate' ? 'Donating' : 'Volunteering')) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="message" class="mb-1.5 block text-sm font-semibold text-navy-800">Message <span class="text-electric-600">*</span></label>
                                <textarea id="message" name="message" rows="5" required
                                    class="w-full rounded-xl border-navy-200 bg-white px-4 py-3 text-navy-900 shadow-sm transition focus:border-electric-500 focus:ring-2 focus:ring-electric-500/30 @error('message') border-red-400 @enderror"
                                    @error('message') aria-invalid="true" aria-describedby="message-error" @enderror>{{ old('message') }}</textarea>
                                @error('message')<p id="message-error" class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div class="flex flex-col items-start gap-4 sm:flex-row sm:items-center sm:justify-between">
                                <p class="text-xs text-navy-400">We typically respond within 2–3 working days.</p>
                                <x-button type="submit" size="lg" icon="arrow-right">Send Message</x-button>
                            </div>
                        </form>
                    </div>
                </x-reveal>
            </div>
        </div>
    </div>
</section>
