<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\MediaItem;
use App\Models\Post;
use App\Support\MediaStorage;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'postCount' => Post::count(),
            'publishedCount' => Post::where('is_active', true)->count(),
            'photoCount' => MediaItem::where('type', 'image')->count(),
            'videoCount' => MediaItem::where('type', 'video')->count(),
            'messageCount' => ContactMessage::count(),
            'recentPosts' => Post::latestFirst()->limit(5)->get(),
            'recentMedia' => MediaItem::latest('id')->limit(8)->get(),
            'uploadLimitMb' => MediaStorage::serverLimitMb(),
        ]);
    }
}
