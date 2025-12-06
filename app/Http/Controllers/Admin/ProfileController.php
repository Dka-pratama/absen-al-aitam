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
        return view('admin.profile', compact('user', 'Header'));
    }

    public function edit()
    {
        $user = Auth::user();
        $Header = "Edit Profil Admin";
        return view('admin.profile-edit', compact('user', 'Header'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username,' . Auth::id(),
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function passwordForm()
    {
        $Header = "Ganti Password";
        return view('admin.change-password', compact('Header'));
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ], [
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
            'new_password.min' => 'Password baru minimal 6 karakter.',
        ]);

        $user = Auth::user();

        // cek password lama
        if (!\Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Password lama tidak sesuai.']);
        }

        // update password
        $user->update([
            'password' => bcrypt($request->new_password)
        ]);

        return redirect()->route('admin.profile')->with('success', 'Password berhasil diganti.');
    }
}
