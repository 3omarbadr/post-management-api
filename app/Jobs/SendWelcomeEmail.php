<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\WelcomeEmail;
use App\Mail\WelcomeEmail as WelcomeEmailMailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private User $user)
    {
    }

    public function handle(): void
    {
        Mail::to($this->user->email)->send(new WelcomeEmailMailable($this->user));
    }
} 