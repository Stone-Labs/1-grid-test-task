<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\PostRating
 *
 * @property int $id
 * @property int $post_id
 * @property int $user_id;
 * @property int $rating
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Post|null $post
 * @property-read User|null $user
 * @method static Builder|PostRating newModelQuery()
 * @method static Builder|PostRating newQuery()
 * @method static Builder|PostRating query()
 * @method static Builder|PostRating whereCreatedAt($value)
 * @method static Builder|PostRating whereId($value)
 * @method static Builder|PostRating wherePostId($value)
 * @method static Builder|PostRating whereUserId($value)
 * @method static Builder|PostRating whereRating($value)
 * @method static Builder|PostRating whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PostRating extends Model
{
    use HasFactory;

    public const TABLE = 'blog_post_ratings';

    protected $table = self::TABLE;

    protected $fillable = [
        'post_id','user_id','rating'
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class,'post_id','id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
