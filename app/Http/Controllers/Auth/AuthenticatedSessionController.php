<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\UserSession;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('username', 'password'))) {
            return back()->withErrors([
                'username' => 'Username atau password salah',
            ]);
        }

        $request->session()->regenerate();

        UserSession::create([
            'user_id' => auth()->id(),
            'login_at' => now(),
            'last_activity_at' => now(),
        ]);
        // redirect sesuai role
        $user = auth()->user();
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('wali')) {
            return redirect()->route('wali.dashboard');
        } elseif ($user->hasRole('siswa')) {
            return redirect()->route('siswa.dashboard');
        }

        return redirect('/'); // fallback
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $userId = auth()->id();

    $session = UserSession::where('user_id', $userId)
        ->whereNull('logout_at')
        ->latest()
        ->first();

    if ($session) {
        $session->update([
            'logout_at' => now(),
            'duration_minutes' => now()->diffInMinutes($session->login_at),
        ]);
    }
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
