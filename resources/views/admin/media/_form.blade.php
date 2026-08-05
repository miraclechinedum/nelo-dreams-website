<section x-data="{ type: '{{ old('type', $item->type) }}' }" class="surface space-y-5 p-6 sm:p-7">
    <h2 class="font-display text-lg font-bold text-navy-900">The file</h2>

    <div>
        <span class="admin-label">What are you uploading?</span>
        <div class="mt-2 grid gap-3 sm:grid-cols-2">
            @foreach ([['image', 'Photo', 'sparkles', 'JPG, PNG, WEBP or GIF'], ['video', 'Video', 'play', 'MP4, MOV, WEBM or M4V']] as [$value, $label, $icon, $note])
                <label class="flex cursor-pointer items-center gap-3 rounded-2xl border p-4 transition"
                       :class="type === '{{ $value }}' ? 'border-electric-400 bg-electric-50/60 ring-1 ring-electric-200' : 'border-navy-200 hover:bg-navy-50'">
                    <input type="radio" name="type" value="{{ $value }}" x-model="type"
                           class="text-electric-500 focus:ring-electric-400">
                    <x-icon :name="$icon" class="h-5 w-5 text-electric-600" />
                    <span>
                        <span class="block text-sm font-semibold text-navy-900">{{ $label }}</span>
                        <span class="block text-xs text-navy-400">{{ $note }}</span>
                    </span>
                </label>
            @endforeach
        </div>
        @error('type') <p class="admin-error">{{ $message }}</p> @enderror
    </div>

    @if ($item->exists)
        <div class="flex items-center gap-4">
            <div class="h-20 w-28 shrink-0 overflow-hidden rounded-xl bg-navy-100">
                @if ($item->isVideo() && ! $item->poster)
                    <div class="flex h-full w-full items-center justify-center text-navy-400"><x-icon name="play" class="h-7 w-7" /></div>
                @else
                    <x-media :src="$item->stillPath()" :alt="$item->title ?? 'Current file'" rounded="rounded-xl" />
                @endif
            </div>
            <div class="min-w-0">
                <p class="truncate text-sm font-semibold text-navy-800">Current file</p>
                <p class="truncate text-xs text-navy-400">{{ $item->path }}</p>
            </div>
        </div>
    @endif

    <div>
        <label for="file" class="admin-label">
            {{ $item->exists ? 'Replace the file' : 'Choose the file' }}
            @unless ($item->exists) <span class="text-rose-500">*</span> @endunless
        </label>
        <input id="file" name="file" type="file" @unless ($item->exists) required @endunless
               :accept="type === 'video' ? 'video/*' : 'image/*'"
               class="admin-input file:mr-4 file:rounded-full file:border-0 file:bg-electric-500 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white">
        <p class="admin-hint">This server accepts files up to about <strong>{{ $uploadLimitMb }}MB</strong> each.</p>
        @error('file') <p class="admin-error">{{ $message }}</p> @enderror
    </div>

    <div x-show="type === 'video'" x-cloak>
        <label for="poster" class="admin-label">Video cover image</label>
        <input id="poster" name="poster" type="file" accept="image/*"
               class="admin-input file:mr-4 file:rounded-full file:border-0 file:bg-navy-900 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white">
        <p class="admin-hint">Optional — the still picture shown before someone presses play.</p>
        @error('poster') <p class="admin-error">{{ $message }}</p> @enderror
    </div>
</section>

<section class="surface space-y-5 p-6 sm:p-7">
    <h2 class="font-display text-lg font-bold text-navy-900">Details</h2>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="title" class="admin-label">Title</label>
            <input id="title" name="title" type="text" maxlength="160"
                   value="{{ old('title', $item->title) }}" class="admin-input" placeholder="Driver outreach, Lugbe">
            @error('title') <p class="admin-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="category" class="admin-label">Category</label>
            <input id="category" name="category" type="text" maxlength="80"
                   value="{{ old('category', $item->category) }}" class="admin-input" placeholder="Community">
            @error('category') <p class="admin-error">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label for="caption" class="admin-label">Caption</label>
        <textarea id="caption" name="caption" rows="2" maxlength="400" class="admin-input"
                  placeholder="Shown when someone hovers over the picture.">{{ old('caption', $item->caption) }}</textarea>
        @error('caption') <p class="admin-error">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="post_id" class="admin-label">Attach to a post</label>
        <select id="post_id" name="post_id" class="admin-input">
            <option value="">Not attached to any post</option>
            @foreach ($posts as $option)
                <option value="{{ $option->id }}" @selected(old('post_id', $item->post_id) == $option->id)>
                    {{ $option->title }}
                </option>
            @endforeach
        </select>
        @error('post_id') <p class="admin-error">{{ $message }}</p> @enderror
    </div>
</section>

<section class="surface space-y-5 p-6 sm:p-7">
    <h2 class="font-display text-lg font-bold text-navy-900">Where it shows</h2>

    <label class="flex items-start gap-3">
        <input type="checkbox" name="in_gallery" value="1" @checked(old('in_gallery', $item->in_gallery))
               class="mt-0.5 rounded border-navy-300 text-electric-500 focus:ring-electric-400">
        <span>
            <span class="block text-sm font-semibold text-navy-800">Show in the home-page “From the field” gallery</span>
            <span class="block text-xs text-navy-400">Untick if it should only appear on its post.</span>
        </span>
    </label>

    <label class="flex items-start gap-3">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $item->is_active))
               class="mt-0.5 rounded border-navy-300 text-electric-500 focus:ring-electric-400">
        <span>
            <span class="block text-sm font-semibold text-navy-800">Visible on the website</span>
            <span class="block text-xs text-navy-400">Untick to hide it everywhere without deleting it.</span>
        </span>
    </label>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="span" class="admin-label">Size in the gallery grid</label>
            <select id="span" name="span" class="admin-input">
                <option value="normal" @selected(old('span', $item->span) === 'normal')>Normal</option>
                <option value="wide" @selected(old('span', $item->span) === 'wide')>Wide (two columns)</option>
                <option value="tall" @selected(old('span', $item->span) === 'tall')>Tall (two rows)</option>
            </select>
            @error('span') <p class="admin-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="sort_order" class="admin-label">Sort order</label>
            <input id="sort_order" name="sort_order" type="number" min="0" max="9999"
                   value="{{ old('sort_order', $item->sort_order ?? 0) }}" class="admin-input">
            <p class="admin-hint">Lower numbers appear first.</p>
            @error('sort_order') <p class="admin-error">{{ $message }}</p> @enderror
        </div>
    </div>
</section>

<div class="flex flex-wrap items-center gap-3">
    <button type="submit" class="admin-btn">{{ $submit }}</button>
    <a href="{{ route('admin.media.index') }}" class="admin-btn-ghost">Back to library</a>
</div>
