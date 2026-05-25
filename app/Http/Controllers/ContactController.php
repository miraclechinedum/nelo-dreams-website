<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    public function store(StoreContactRequest $request): RedirectResponse
    {
        ContactMessage::create($request->safe()->except('website'));

        return back()
            ->with('contact_success', 'Thank you for reaching out — we’ll be in touch soon.')
            ->withFragment('contact');
    }
}
