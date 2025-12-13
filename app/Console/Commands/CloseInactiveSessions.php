<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserSession;

class CloseInactiveSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sessions:close';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $limit = now()->subMinutes(config('session.lifetime'));

        UserSession::whereNull('logout_at')
            ->where('last_activity_at', '<', $limit)
            ->get()
            ->each(function ($session) {
                $session->update([
                    'logout_at' => $session->last_activity_at,
                    'duration_minutes' => $session->last_activity_at->diffInMinutes($session->login_at),
                ]);
            });
    }
}
