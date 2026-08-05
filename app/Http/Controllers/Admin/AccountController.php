<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AccountController extends Controller
{
    public function edit(): View
    {
        return view('admin.account');
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160', Rule::unique('users', 'email')->ignore($user->id)],
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'confirmed', Password::min(10)],
        ], [
            'current_password.current_password' => 'That is not your current password.',
            'current_password.required_with' => 'Enter your current password to set a new one.',
        ]);

        $user->fill(['name' => $data['name'], 'email' => $data['email']]);

        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return back()->with('status', 'Your details have been saved.');
    }
}
