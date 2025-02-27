<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Models\User;
use App\Notifications\NewUserNotification;
use App\Notifications\WelcomeEmail;

class SendWelcomeEmail
{
    public function handle(UserRegistered $event): void
    {
        $event->user->notify(new WelcomeEmail());

        User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->each(function ($admin) use ($event) {
            $admin->notify(new NewUserNotification($event->user));
        });
    }
}
