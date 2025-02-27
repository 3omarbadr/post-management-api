<?php

namespace App\Observers;

use App\Jobs\ProcessPostApproval;
use App\Models\Post;
use App\Notifications\PostStatusUpdated;

class PostObserver
{
    public function created(Post $post): void
    {
//        ProcessPostApproval::dispatch($post);
    }

    public function updated(Post $post): void
    {
        if ($post->wasChanged('status')) {
            $post->user->notify(new PostStatusUpdated($post, $post->status));
        }
    }
}
