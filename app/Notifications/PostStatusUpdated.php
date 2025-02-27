<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private Post $post)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Post Has Been ' . ucfirst($this->post->status->value))
            ->line('Your post "' . $this->post->title . '" has been ' . $this->post->status->value)
            ->action('View Post', url('/posts/' . $this->post->id));
    }
} 