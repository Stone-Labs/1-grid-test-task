<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    /**
     * @var PostService
     */
    protected PostService $postService;

    /**
     * @param PostService $postService
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $posts = $this->postService->index(10);
        return view('blog.index', ['posts' => $posts, 'user' => \Auth::user()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostRequest $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(PostRequest $request): RedirectResponse
    {
        Validator::make($request->validated(), [
            'slug' => [
                Rule::unique(Post::TABLE, 'slug'),
            ],
        ])->validate();

        $this->postService->store($request->user(), $request->safe()->collect());
        return \response()->redirectToRoute('blog.index')
            ->with('success', true)
            ->with('message', 'Post created successful !');
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return Response|RedirectResponse
     */
    public function show(string $slug): Response|RedirectResponse
    {
        $post = $this->postService->getBySlug($slug);
        if ($post) {
            return \response()->view('blog.show', ['post' => $post]);
        }
        return \response()->redirectToRoute('blog.index')
            ->withErrors(['post' => __('Post not found')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return RedirectResponse|View
     */
    public function edit(int $id): RedirectResponse|View
    {
        try {
            $post = $this->postService->getPostIdUpdateUser($id, \Auth::user());
        } catch (\Exception $exception) {
            return back()->withErrors(['message' => $exception->getMessage()]);
        }

        return view('blog.edit', ['post' => $post, 'user' => \Auth::user()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PostRequest $request
     * @param int $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(PostRequest $request, int $id): RedirectResponse
    {
        Validator::make($request->validated(), [
            'slug' => [
                Rule::unique(Post::TABLE, 'slug')->ignore($id),
            ],
        ])->validate();

        try {
            $this->postService->update($id, $request->user(), $request->safe()->collect());
        } catch (\Exception $exception) {
            return back()->withErrors(['message' => $exception->getMessage()]);
        } catch (\Throwable $throwable) {
            return back()->withErrors(['message' => $throwable->getMessage()]);
        }

        return \response()->redirectToRoute('blog.index')
            ->with('success', true)
            ->with('message', 'Post updated successful !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            $this->postService->destroy($id, \Auth::user());
        } catch (\Exception $exception) {
            return back()->withErrors(['message' => $exception->getMessage()]);
        }
        return back()->with('success', true)->with('message', 'Post deleted successful !');
    }
}
