<?php

namespace App\Models;

use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use function Symfony\Component\Translation\t;

/**
 * App\Models\Post
 *
 * @property int $id
 * @property string $slug
 * @property int $user_id
 * @property string $title
 * @property string $content
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|PostRating[] $ratings
 * @property-read int|null $total_rating
 * @property-read User|null $user
 * @property-read int $myRating
 * @method static PostFactory factory(...$parameters)
 * @method static Builder|Post newModelQuery()
 * @method static Builder|Post newQuery()
 * @method static Builder|Post query()
 * @method static Builder|Post whereContent($value)
 * @method static Builder|Post whereCreatedAt($value)
 * @method static Builder|Post whereId($value)
 * @method static Builder|Post whereSlug($value)
 * @method static Builder|Post whereTitle($value)
 * @method static Builder|Post whereUpdatedAt($value)
 * @method static Builder|Post whereUserId($value)
 * @mixin \Eloquent
 */
class Post extends Model
{
    use HasFactory;

    public const TABLE = 'blog_posts';

    protected $table = self::TABLE;

    protected $fillable = [
      'slug','user_id','title','content'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(PostRating::class,'post_id','id');
    }

    public function my_rating(){
        return $this->hasOne(PostRating::class,'post_id','id')
            ->where('user_id',(\Auth::user() ? \Auth::user()->id : null ));
    }

    public function getMyRatingAttribute(): int
    {
        // if relation is not loaded already, let's do it first
        if ( ! array_key_exists('my_rating', $this->relations)){
            $this->load('my_rating');
        }

        $related = $this->getRelation('my_rating');
        return ($related) ? (int) $related->rating : 0;
    }
}
