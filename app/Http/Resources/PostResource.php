<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'status' => $this->status,
            'user' => new UserResource($this->user),
            'categories' => CategoryResource::collection($this->categories),
            'comments' => CommentResource::collection($this->comments),
        ];
    }
} 