<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\View\View;

class UpdateController extends Controller
{
    public function index(): View
    {
        return view('pages.updates.index', [
            'posts' => Post::active()->with('media')->latestFirst()->paginate(9),
        ]);
    }

    public function show(Post $post): View
    {
        abort_unless($post->is_active, 404);

        return view('pages.updates.show', [
            'post' => $post->load('media'),
            'more' => Post::active()->latestFirst()->whereKeyNot($post->id)->limit(3)->get(),
        ]);
    }
}
