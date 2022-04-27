<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Throwable;

class PostService
{
    public const PAGE = 5;

    protected Builder $model;

    public function __construct()
    {
        $this->model = Post::with('my_rating')->withAvg('ratings as total_rating', 'rating');
    }

    /**
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function index(int $perPage = self::PAGE): LengthAwarePaginator
    {
        return $this->model->orderByDesc('id')->paginate($perPage);
    }

    /**
     * @param User $user
     * @param Collection $data
     * @return Post
     */
    public function store(User $user, Collection $data): Post
    {
        return Post::create([
            'user_id' => $user->id,
            'slug' => $data->get('slug'),
            'title' => $data->get('title'),
            'content' => $data->get('content'),
        ]);
    }

    /**
     * @param int $post_id
     * @param User $user
     * @param Collection $data
     * @return Post
     * @throws Throwable
     * @throws ValidationException
     */
    public function update(int $post_id, User $user, Collection $data): Post
    {
        $post = $this->getPostIdUpdateUser($post_id, $user);
        $post->updateOrFail([
            'slug' => $data->get('slug'),
            'title' => $data->get('title'),
            'content' => $data->get('content'),
        ]);
        return $post;
    }

    /**
     * @param string $slug
     * @return Post|null
     */
    public function getBySlug(string $slug): Post|null
    {
        return $this->model->whereSlug($slug)->first();
    }

    /**
     * @param int $post_id
     * @param User $user
     * @return Post
     * @throws ValidationException
     */
    public function getPostIdUpdateUser(int $post_id, User $user): Post
    {
        $post = $this->model->find($post_id);
        if (!$post) {
            return throw ValidationException::withMessages(['post' => 'Post not found']);
        }
        if ($user->id !== $post->user_id) {
            return throw ValidationException::withMessages(['post' => 'Post access denied']);
        }
        return $post;
    }

    /**
     * @param int $post_id
     * @param User $user
     * @throws ValidationException
     */
    public function destroy(int $post_id, User $user)
    {
        $post = $this->getPostIdUpdateUser($post_id, $user);
        $post->delete();
    }
}
