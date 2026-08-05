<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostRequest;
use App\Models\MediaItem;
use App\Models\Post;
use App\Support\MediaStorage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class PostController extends Controller
{
    public function index(): View
    {
        return view('admin.posts.index', [
            'posts' => Post::withCount('media')->latestFirst()->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.posts.create', [
            'post' => new Post(['is_active' => true, 'sort_order' => 0]),
            'uploadLimitMb' => MediaStorage::serverLimitMb(),
        ]);
    }

    public function store(PostRequest $request): RedirectResponse
    {
        $post = Post::create($request->safe()->except(['cover_image', 'media']) + [
            'cover_image' => $request->hasFile('cover_image')
                ? MediaStorage::store($request->file('cover_image'))
                : null,
        ]);

        $this->attachMedia($post, $request->file('media', []));

        return redirect()
            ->route('admin.posts.edit', $post)
            ->with('status', 'Post created. Add or reorder photos below whenever you like.');
    }

    public function edit(Post $post): View
    {
        return view('admin.posts.edit', [
            'post' => $post->load('media'),
            'uploadLimitMb' => MediaStorage::serverLimitMb(),
        ]);
    }

    public function update(PostRequest $request, Post $post): RedirectResponse
    {
        $post->update($request->safe()->except(['cover_image', 'media']) + [
            'cover_image' => MediaStorage::replace($request->file('cover_image'), $post->cover_image),
        ]);

        $this->attachMedia($post, $request->file('media', []));

        return redirect()
            ->route('admin.posts.edit', $post)
            ->with('status', 'Post updated.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        MediaStorage::delete($post->cover_image);

        foreach ($post->media as $item) {
            MediaStorage::delete($item->path);
            MediaStorage::delete($item->poster);
            $item->delete();
        }

        $post->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('status', 'Post deleted.');
    }

    /** Publish / unpublish without opening the full form. */
    public function toggle(Post $post): RedirectResponse
    {
        $post->update(['is_active' => ! $post->is_active]);

        return back()->with('status', $post->is_active
            ? 'Post is now live on the site.'
            : 'Post hidden from the site.');
    }

    /**
     * Save any files dropped on the post form as media attached to the post.
     *
     * @param  array<int, UploadedFile>  $files
     */
    private function attachMedia(Post $post, array $files): void
    {
        $sort = (int) $post->media()->max('sort_order');

        foreach ($files as $file) {
            $isVideo = str_starts_with((string) $file->getMimeType(), 'video/');

            $post->media()->create([
                'type' => $isVideo ? 'video' : 'image',
                'path' => MediaStorage::store($file),
                'title' => $post->title,
                'caption' => $post->title,
                'category' => $post->category,
                'span' => 'normal',
                'in_gallery' => ! $isVideo,
                'sort_order' => ++$sort,
                'is_active' => true,
            ]);
        }
    }

    /** Remove a single attachment from a post. */
    public function detachMedia(Request $request, Post $post, MediaItem $media): RedirectResponse
    {
        abort_unless($media->post_id === $post->id, 404);

        MediaStorage::delete($media->path);
        MediaStorage::delete($media->poster);
        $media->delete();

        return back()->with('status', 'Attachment removed.');
    }
}
