<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PostRejected extends Notification
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
            ->subject('Your Post Status Update')
            ->line('Your post has been reviewed.')
            ->line('Title: ' . $this->post->title)
            ->line('Unfortunately, your post was not approved at this time.')
            ->line('You can submit a new post or contact the administrators for more information.');
    }
} 