<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUserRegistered extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private readonly User $newUser)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New User Registration')
            ->line('A new user has registered: ' . $this->newUser->name)
            ->line('Email: ' . $this->newUser->email)
            ->action('View User', url('/users/profile' . $this->newUser->id));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'New user registered: ' . $this->newUser->name,
            'user_id' => $this->newUser->id,
        ];
    }
}
