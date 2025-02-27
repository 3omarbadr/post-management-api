<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\NewUserRegistered;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyAdminsOfNewUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private User $newUser)
    {
    }

    public function handle(): void
    {
        User::role('admin')->each(function ($admin) {
            $admin->notify(new NewUserRegistered($this->newUser));
        });
    }
}
