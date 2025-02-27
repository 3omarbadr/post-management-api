<?php

namespace App\Events;

use App\Jobs\LogUserRegistration;
use App\Jobs\NotifyAdminsOfNewUser;
use App\Jobs\SendWelcomeEmail;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserRegistered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public User $user)
    {
        SendWelcomeEmail::dispatch($user);
        NotifyAdminsOfNewUser::dispatch($user);
        LogUserRegistration::dispatch($user);
    }
}
