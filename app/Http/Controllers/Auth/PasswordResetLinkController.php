<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'email' => ['required', 'email', 'exists:users,email'],
    ]);

    $user = User::where('email', $request->email)->first();

    // generate token manual
    $token = Str::random(64);

    // simpan token (sesuai Laravel 10+)
    DB::table('password_reset_tokens')->updateOrInsert(
        ['email' => $user->email],
        [
            'token' => bcrypt($token),
            'created_at' => now(),
        ]
    );

    // kirim email via Notification Laravel
    $user->notify(new ResetPassword($token));

    return back()->with(
        'success',
        '📧 Email reset password berhasil dikirim. Silakan cek inbox atau folder spam.'
    );
}
}
