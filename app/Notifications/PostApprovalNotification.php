<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostApprovalNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private Post $post)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Post Requires Approval')
            ->line('A new post requires your approval:')
            ->line('Title: ' . $this->post->title)
            ->action('Review Post', url('/posts/' . $this->post->id));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'post_id' => $this->post->id,
            'title' => $this->post->title,
        ];
    }
}
