<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewPostPendingApproval extends Notification
{
    use Queueable;

    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Post Pending Approval')
            ->line('A new post requires your approval.')
            ->line('Title: ' . $this->post->title)
            ->line('Author: ' . $this->post->user->name)
            ->action('Review Post', url('/admin/posts/' . $this->post->id))
            ->line('Please review the content and approve or reject it.');
    }
} 