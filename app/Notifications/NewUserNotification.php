<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUserNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private User $newUser)
    {
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New User Registration')
            ->line('A new user has registered: ' . $this->newUser->name)
            ->line('Email: ' . $this->newUser->email)
            ->action('View User', url('/admin/users/' . $this->newUser->id));
    }

    public function toArray($notifiable): array
    {
        return [
            'user_id' => $this->newUser->id,
            'name' => $this->newUser->name,
            'email' => $this->newUser->email,
        ];
    }
} 