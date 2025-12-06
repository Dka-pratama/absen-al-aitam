<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $Header = "Profil Admin";
        $user = Auth::user();
        return view('admin.profile', compact('user','Header'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('admin.profile-edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
        ]);

        $user->update($request->only('name', 'username', 'email'));

        return redirect()->route('admin.profile')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    public function changePassword()
    {
        $user = Auth::user();
        return view('admin.change-password', compact('user'));
    }
}
