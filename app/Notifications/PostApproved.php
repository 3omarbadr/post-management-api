<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PostApproved extends Notification
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
            ->subject('Your Post Has Been Approved!')
            ->line('Congratulations! Your post has been approved.')
            ->line('Title: ' . $this->post->title)
            ->action('View Post', url('/posts/' . $this->post->id))
            ->line('Thank you for contributing to our community!');
    }
} 