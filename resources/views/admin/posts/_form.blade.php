@php
    $categories = ['Community Outreach', 'School Campaign', 'Partnership', 'Event', 'Training', 'Announcement'];
@endphp

<section class="surface space-y-5 p-6 sm:p-7">
    <h2 class="font-display text-lg font-bold text-navy-900">The story</h2>

    <div>
        <label for="title" class="admin-label">Headline <span class="text-rose-500">*</span></label>
        <input id="title" name="title" type="text" required maxlength="180"
               value="{{ old('title', $post->title) }}" class="admin-input"
               placeholder="Mental Health Outreach for Commercial Drivers in Abuja">
        @error('title') <p class="admin-error">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="summary" class="admin-label">Short summary <span class="text-rose-500">*</span></label>
        <textarea id="summary" name="summary" rows="3" required maxlength="600" class="admin-input"
                  placeholder="One or two sentences — this is what people see in the list of updates.">{{ old('summary', $post->summary) }}</textarea>
        @error('summary') <p class="admin-error">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="body" class="admin-label">Full write-up</label>
        <textarea id="body" name="body" rows="14" class="admin-input font-mono text-sm"
                  placeholder="Paste the full text here. Line breaks and blank lines are kept exactly as you type them — no formatting codes needed.">{{ old('body', $post->body) }}</textarea>
        <p class="admin-hint">Plain text. Start a line with “- ” for a bullet point.</p>
        @error('body') <p class="admin-error">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="hashtags" class="admin-label">Hashtags</label>
        <input id="hashtags" name="hashtags" type="text" maxlength="255"
               value="{{ old('hashtags', $post->hashtags) }}" class="admin-input"
               placeholder="#MentalHealthAwareness #NeloDreamsFoundation">
        @error('hashtags') <p class="admin-error">{{ $message }}</p> @enderror
    </div>
</section>

<section class="surface space-y-5 p-6 sm:p-7">
    <h2 class="font-display text-lg font-bold text-navy-900">When &amp; where</h2>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="category" class="admin-label">Category</label>
            <input id="category" name="category" type="text" list="post-categories" maxlength="80"
                   value="{{ old('category', $post->category) }}" class="admin-input" placeholder="Community Outreach">
            <datalist id="post-categories">
                @foreach ($categories as $category)
                    <option value="{{ $category }}"></option>
                @endforeach
            </datalist>
            @error('category') <p class="admin-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="location" class="admin-label">Location</label>
            <input id="location" name="location" type="text" maxlength="180"
                   value="{{ old('location', $post->location) }}" class="admin-input"
                   placeholder="Police Signpost, Lugbe, FCT Abuja">
            @error('location') <p class="admin-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="happened_on" class="admin-label">Date</label>
            <input id="happened_on" name="happened_on" type="date" class="admin-input"
                   value="{{ old('happened_on', $post->happened_on?->format('Y-m-d')) }}">
            <p class="admin-hint">Used to sort updates, newest first.</p>
            @error('happened_on') <p class="admin-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="period" class="admin-label">Date label</label>
            <input id="period" name="period" type="text" maxlength="80"
                   value="{{ old('period', $post->period) }}" class="admin-input" placeholder="12 June 2025">
            <p class="admin-hint">Optional — shown instead of the date if you want wording like “Friday, 31 July 2026, 10:00 AM”.</p>
            @error('period') <p class="admin-error">{{ $message }}</p> @enderror
        </div>
    </div>
</section>

<section class="surface space-y-5 p-6 sm:p-7">
    <h2 class="font-display text-lg font-bold text-navy-900">Pictures &amp; videos</h2>

    <div>
        <label for="cover_image" class="admin-label">Cover photo</label>
        @if ($post->cover_image)
            <div class="mt-2 flex items-center gap-4">
                <div class="h-20 w-32 overflow-hidden rounded-xl bg-navy-100">
                    <x-media :src="$post->cover_image" :alt="$post->title" rounded="rounded-xl" />
                </div>
                <p class="text-xs text-navy-400">Choosing a new file replaces this one.</p>
            </div>
        @endif
        <input id="cover_image" name="cover_image" type="file" accept="image/*"
               class="admin-input file:mr-4 file:rounded-full file:border-0 file:bg-navy-900 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white">
        <p class="admin-hint">Optional — if you leave it empty, the first attached photo is used. JPG, PNG or WEBP, up to 8MB.</p>
        @error('cover_image') <p class="admin-error">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="media" class="admin-label">Attach photos and videos</label>
        <input id="media" name="media[]" type="file" multiple accept="image/*,video/*"
               class="admin-input file:mr-4 file:rounded-full file:border-0 file:bg-electric-500 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white">
        <p class="admin-hint">
            Pick several at once. Photos also appear in the “From the field” gallery on the home page
            (you can turn that off per photo under <em>Photos &amp; videos</em>).
            This server accepts files up to about <strong>{{ $uploadLimitMb }}MB</strong> each.
        </p>
        @error('media') <p class="admin-error">{{ $message }}</p> @enderror
        @error('media.*') <p class="admin-error">{{ $message }}</p> @enderror
    </div>

    @if ($post->exists && $post->media->isNotEmpty())
        <div>
            <p class="admin-label mb-3">Already attached ({{ $post->media->count() }})</p>
            <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
                @foreach ($post->media as $item)
                    <div class="group relative aspect-square overflow-hidden rounded-2xl bg-navy-100">
                        @if ($item->isVideo())
                            <video class="h-full w-full object-cover" preload="metadata" muted
                                   @if ($item->poster) poster="{{ asset($item->poster) }}" @endif>
                                <source src="{{ asset($item->path) }}">
                            </video>
                            <span class="pointer-events-none absolute left-2 top-2 admin-chip bg-navy-950/70 text-white">
                                <x-icon name="play" class="h-3.5 w-3.5" /> Video
                            </span>
                        @else
                            <x-media :src="$item->path" :alt="$item->title ?? $post->title" rounded="rounded-2xl" />
                        @endif

                        <div class="absolute inset-x-0 bottom-0 flex items-center justify-between gap-2 bg-navy-950/70 p-2 opacity-0 transition group-hover:opacity-100 focus-within:opacity-100">
                            <a href="{{ route('admin.media.edit', $item) }}"
                               class="rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-navy-900 hover:bg-white">Edit</a>
                            <x-admin.confirm-button form="detach-{{ $item->id }}"
                                :title="'Remove this '.($item->isVideo() ? 'video' : 'photo').'?'"
                                message="It will be taken off the post and deleted from the server. This cannot be undone."
                                confirm-label="Remove"
                                class="rounded-full bg-rose-500 px-3 py-1 text-xs font-semibold text-white hover:bg-rose-600">
                                Remove
                            </x-admin.confirm-button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</section>

<section class="surface space-y-5 p-6 sm:p-7">
    <h2 class="font-display text-lg font-bold text-navy-900">Publishing</h2>

    <label class="flex items-start gap-3">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $post->is_active))
               class="mt-0.5 rounded border-navy-300 text-electric-500 focus:ring-electric-400">
        <span>
            <span class="block text-sm font-semibold text-navy-800">Show this post on the website</span>
            <span class="block text-xs text-navy-400">Untick to keep it as a draft only you can see.</span>
        </span>
    </label>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="slug" class="admin-label">Web address</label>
            <div class="mt-1.5 flex items-center gap-2">
                <span class="shrink-0 text-xs text-navy-400">/updates/</span>
                <input id="slug" name="slug" type="text" maxlength="200"
                       value="{{ old('slug', $post->slug) }}" class="admin-input !mt-0" placeholder="left blank = made from the headline">
            </div>
            @error('slug') <p class="admin-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="sort_order" class="admin-label">Sort order</label>
            <input id="sort_order" name="sort_order" type="number" min="0" max="9999"
                   value="{{ old('sort_order', $post->sort_order ?? 0) }}" class="admin-input">
            <p class="admin-hint">Leave at 0 — updates are normally listed newest first.</p>
            @error('sort_order') <p class="admin-error">{{ $message }}</p> @enderror
        </div>
    </div>
</section>

<div class="flex flex-wrap items-center gap-3">
    <button type="submit" class="admin-btn">{{ $submit }}</button>
    <a href="{{ route('admin.posts.index') }}" class="admin-btn-ghost">Back to posts</a>

    @if ($post->exists)
        <x-admin.confirm-button form="delete-post" class="admin-btn-danger ml-auto"
            title="Delete this post?"
            :message="'“'.$post->title.'” and its '.$post->media->count().' attached '.Str::plural('file', $post->media->count()).' will be deleted permanently.'"
            confirm-label="Delete post">
            Delete post
        </x-admin.confirm-button>
    @endif
</div>
