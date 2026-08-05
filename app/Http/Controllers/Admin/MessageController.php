<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class MessageController extends Controller
{
    public function index(): View
    {
        return view('admin.messages.index', [
            'messages' => ContactMessage::latest('id')->paginate(20),
        ]);
    }

    public function destroy(ContactMessage $message): RedirectResponse
    {
        $message->delete();

        return back()->with('status', 'Message deleted.');
    }
}
