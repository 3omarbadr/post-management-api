<?php

namespace App\Models;

use App\Enums\PostStatus;
use App\Observers\PostObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(PostObserver::class)]
class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'status',
        'user_id',
    ];

    protected $casts = [
        'status' => PostStatus::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeWithMinimumComments(Builder $query, array $filters): Builder
    {
        return $query->when(data_get($filters, 'minimum_comments'), function (Builder $query, $count) {
            return $query->withCount('comments')->having('comments_count', '>=', $count);
        });
    }

    public function scopeByStatus(Builder $query, array $filters): Builder
    {
        return $query->when(data_get($filters, 'status'), function (Builder $query, $status) {
            return $query->where('status', $status);
        });
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', PostStatus::PENDING);
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', PostStatus::APPROVED);
    }

    public function scopeRejected(Builder $query): Builder
    {
        return $query->where('status', PostStatus::REJECTED);
    }
}
