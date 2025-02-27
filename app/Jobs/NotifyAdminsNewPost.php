<?php

namespace App\Jobs;

use App\Models\Post;
use App\Models\User;
use App\Notifications\NewPostPendingApproval;
use App\Notifications\PostApproved;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Permission\Models\Role;

class NotifyAdminsNewPost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function handle()
    {
        $this->post->user->role('admin')->each(function ($admin) {
            $admin->notify(new PostApproved($this->post));
        });
    }
} 