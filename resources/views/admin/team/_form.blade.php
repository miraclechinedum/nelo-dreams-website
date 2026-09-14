<section class="surface space-y-5 p-6 sm:p-7">
    <h2 class="font-display text-lg font-bold text-navy-900">Who they are</h2>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="name" class="admin-label">Full name <span class="text-rose-500">*</span></label>
            <input id="name" name="name" type="text" maxlength="120" required
                   value="{{ old('name', $member->name) }}" class="admin-input" placeholder="Coach Ebere Amariazu">
            @error('name') <p class="admin-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="role" class="admin-label">Role <span class="text-rose-500">*</span></label>
            <input id="role" name="role" type="text" maxlength="120" required
                   value="{{ old('role', $member->role) }}" class="admin-input" placeholder="Executive Director">
            @error('role') <p class="admin-error">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label for="bio" class="admin-label">Short bio</label>
        <textarea id="bio" name="bio" rows="3" maxlength="1000" class="admin-input"
                  placeholder="A sentence or two about what they do at the foundation.">{{ old('bio', $member->bio) }}</textarea>
        <p class="admin-hint">Optional — shown under their name on the website.</p>
        @error('bio') <p class="admin-error">{{ $message }}</p> @enderror
    </div>
</section>

<section class="surface space-y-5 p-6 sm:p-7">
    <h2 class="font-display text-lg font-bold text-navy-900">Photo</h2>

    <div class="flex items-center gap-4">
        <div class="h-20 w-20 shrink-0 overflow-hidden rounded-2xl bg-navy-100">
            @if ($member->hasPhoto())
                <img src="{{ asset($member->photo) }}" alt="{{ $member->name }}" class="h-full w-full object-cover">
            @else
                <div class="flex h-full w-full items-center justify-center bg-navy-900 font-display text-xl font-bold text-electric-300">
                    {{ $member->exists ? $member->initials() : '?' }}
                </div>
            @endif
        </div>
        <div class="min-w-0">
            <p class="text-sm font-semibold text-navy-800">{{ $member->hasPhoto() ? 'Current photo' : 'No photo yet' }}</p>
            <p class="truncate text-xs text-navy-400">
                {{ $member->hasPhoto() ? $member->photo : 'Their initials are shown on the website until you add one.' }}
            </p>
        </div>
    </div>

    <div>
        <label for="photo" class="admin-label">{{ $member->hasPhoto() ? 'Replace the photo' : 'Upload a photo' }}</label>
        <input id="photo" name="photo" type="file" accept="image/*"
               class="admin-input file:mr-4 file:rounded-full file:border-0 file:bg-electric-500 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white">
        <p class="admin-hint">
            A square headshot looks best — around 800&times;800. JPG, PNG or WEBP,
            up to about <strong>{{ $uploadLimitMb }}MB</strong>.
        </p>
        @error('photo') <p class="admin-error">{{ $message }}</p> @enderror
    </div>
</section>

<section class="surface space-y-5 p-6 sm:p-7">
    <h2 class="font-display text-lg font-bold text-navy-900">Contact &amp; links</h2>
    <p class="-mt-3 text-sm text-navy-500">All optional. Leave blank to point visitors at the foundation inbox instead.</p>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="email" class="admin-label">Email</label>
            <input id="email" name="email" type="email" maxlength="160"
                   value="{{ old('email', $member->email) }}" class="admin-input" placeholder="{{ config('site.email') }}">
            @error('email') <p class="admin-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="phone" class="admin-label">Phone</label>
            <input id="phone" name="phone" type="tel" maxlength="40"
                   value="{{ old('phone', $member->phone) }}" class="admin-input" placeholder="+234 800 000 0000">
            @error('phone') <p class="admin-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="facebook_url" class="admin-label">Facebook link</label>
            <input id="facebook_url" name="facebook_url" type="url" maxlength="255"
                   value="{{ old('facebook_url', $member->facebook_url) }}" class="admin-input" placeholder="https://www.facebook.com/...">
            @error('facebook_url') <p class="admin-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="linkedin_url" class="admin-label">LinkedIn link</label>
            <input id="linkedin_url" name="linkedin_url" type="url" maxlength="255"
                   value="{{ old('linkedin_url', $member->linkedin_url) }}" class="admin-input" placeholder="https://www.linkedin.com/in/...">
            @error('linkedin_url') <p class="admin-error">{{ $message }}</p> @enderror
        </div>
    </div>
</section>

<section class="surface space-y-5 p-6 sm:p-7">
    <h2 class="font-display text-lg font-bold text-navy-900">Where they show</h2>

    <label class="flex items-start gap-3">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $member->is_active))
               class="mt-0.5 rounded border-navy-300 text-electric-500 focus:ring-electric-400">
        <span>
            <span class="block text-sm font-semibold text-navy-800">Show on the website</span>
            <span class="block text-xs text-navy-400">Untick to hide them from the home-page team section without deleting them.</span>
        </span>
    </label>

    <div class="sm:max-w-xs">
        <label for="sort_order" class="admin-label">Sort order</label>
        <input id="sort_order" name="sort_order" type="number" min="0" max="9999"
               value="{{ old('sort_order', $member->sort_order ?? 0) }}" class="admin-input">
        <p class="admin-hint">Lower numbers appear first — leadership usually goes at the top.</p>
        @error('sort_order') <p class="admin-error">{{ $message }}</p> @enderror
    </div>
</section>

<div class="flex flex-wrap items-center gap-3">
    <button type="submit" class="admin-btn">{{ $submit }}</button>
    <a href="{{ route('admin.team.index') }}" class="admin-btn-ghost">Back to the team</a>
</div>
