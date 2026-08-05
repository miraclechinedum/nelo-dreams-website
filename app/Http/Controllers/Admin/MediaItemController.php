<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MediaItemRequest;
use App\Models\MediaItem;
use App\Models\Post;
use App\Support\MediaStorage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MediaItemController extends Controller
{
    public function index(Request $request): View
    {
        $type = $request->query('type');

        return view('admin.media.index', [
            'items' => MediaItem::with('post')
                ->when(in_array($type, ['image', 'video'], true), fn ($q) => $q->where('type', $type))
                ->orderBy('sort_order')
                ->orderByDesc('id')
                ->paginate(24)
                ->withQueryString(),
            'type' => $type,
        ]);
    }

    public function create(Request $request): View
    {
        return view('admin.media.create', [
            'item' => new MediaItem([
                'type' => $request->query('type') === 'video' ? 'video' : 'image',
                'span' => 'normal',
                'in_gallery' => true,
                'is_active' => true,
                'sort_order' => 0,
                'post_id' => $request->query('post'),
            ]),
            'posts' => Post::latestFirst()->get(),
            'uploadLimitMb' => MediaStorage::serverLimitMb(),
        ]);
    }

    public function store(MediaItemRequest $request): RedirectResponse
    {
        MediaItem::create($request->safe()->except(['file', 'poster']) + [
            'path' => MediaStorage::store($request->file('file')),
            'poster' => $request->hasFile('poster')
                ? MediaStorage::store($request->file('poster'))
                : null,
        ]);

        return redirect()
            ->route('admin.media.index')
            ->with('status', 'Upload saved.');
    }

    public function edit(MediaItem $media): View
    {
        return view('admin.media.edit', [
            'item' => $media,
            'posts' => Post::latestFirst()->get(),
            'uploadLimitMb' => MediaStorage::serverLimitMb(),
        ]);
    }

    public function update(MediaItemRequest $request, MediaItem $media): RedirectResponse
    {
        $media->update($request->safe()->except(['file', 'poster']) + [
            'path' => MediaStorage::replace($request->file('file'), $media->path),
            'poster' => MediaStorage::replace($request->file('poster'), $media->poster),
        ]);

        return redirect()
            ->route('admin.media.index')
            ->with('status', 'Upload updated.');
    }

    public function destroy(MediaItem $media): RedirectResponse
    {
        MediaStorage::delete($media->path);
        MediaStorage::delete($media->poster);
        $media->delete();

        return back()->with('status', 'Upload deleted.');
    }

    public function toggle(MediaItem $media): RedirectResponse
    {
        $media->update(['is_active' => ! $media->is_active]);

        return back()->with('status', $media->is_active
            ? 'Now showing on the site.'
            : 'Hidden from the site.');
    }
}
