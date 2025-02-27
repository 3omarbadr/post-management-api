<?php

namespace App\Http\Controllers;

use App\Enums\PostStatus;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Jobs\NotifyAdminsNewPost;
use App\Jobs\NotifyAuthorPostApproved;
use App\Jobs\NotifyAuthorPostRejected;

class PostController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request): JsonResponse
    {
        $posts = Post::query()->withMinimumComments($request->only('minimum_comments'))
            ->byStatus($request->only('status'))
            ->when($request->has('search'), function ($query) use ($request) {
                $query->where('title', 'like', "%{$request->search}%")
                    ->orWhere('content', 'like', "%{$request->search}%");
        })->with(['user', 'categories'])->latest()->paginate(10);

        return $this->success(PostResource::collection($posts));
    }

    public function store(StorePostRequest $request): JsonResponse
    {
        $post = $request->user()->posts()->create([
            ...$request->validated(),
            'status' => PostStatus::PENDING,
        ]);

        if ($request->has('categories')) {
            $post->categories()->sync($request->categories);
        }

        NotifyAdminsNewPost::dispatch($post);

        return $this->success(new PostResource($post), 'Post created and pending approval', 201);
    }

    public function show(Post $post): JsonResponse
    {
        return $this->success(new PostResource($post));
    }

    public function update(UpdatePostRequest $request, Post $post): JsonResponse
    {
        $post->update($request->validated());

        if ($request->has('categories')) {
            $post->categories()->sync($request->categories);
        }

        return response()->json($post);
    }

    public function approve(Post $post): JsonResponse
    {
        $post->update(['status' => PostStatus::APPROVED]);

        NotifyAuthorPostApproved::dispatch($post);

        return $this->success(new PostResource($post), 'Post approved successfully');
    }

    public function reject(Post $post): JsonResponse
    {
        $post->update(['status' => PostStatus::REJECTED]);

        NotifyAuthorPostRejected::dispatch($post);

        return $this->success(new PostResource($post), 'Post rejected');
    }
}
