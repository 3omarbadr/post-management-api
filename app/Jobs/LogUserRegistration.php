<?php

namespace App\Jobs;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LogUserRegistration implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private User $user)
    {
    }

    public function handle(): void
    {
        ActivityLog::create([
            'type' => 'user_registered',
            'causer_type' => User::class,
            'causer_id' => $this->user->id,
            'subject_type' => User::class,
            'subject_id' => $this->user->id,
            'properties' => [
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
        ]);
    }
} 