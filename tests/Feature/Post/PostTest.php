<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private User $user;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->user = User::factory()->create();

        $post_data = Post::factory()->definition();
        $post_data['user_id'] = (User::factory()->create())->id;
        Post::create($post_data);
    }

    /**
     * @return void
     */
    public function test_unauthorised_user_cant_view_blog()
    {
        $this->get(route('blog.index'));
        $this->assertGuest();
    }

    public function test_any_user_can_view_blog(){
        $response = $this->actingAs($this->user)->get(route('blog.index'));
        $response->assertStatus(200);
    }

    public function test_any_user_read_post(){
        $post = Post::first();
        $response = $this->actingAs($this->user)->get(route('blog.show',$post->slug));
        $response->assertStatus(200);
    }

    public function test_no_author_cant_edit_post(){
        $post = Post::first();
        $response = $this->actingAs($this->user)->get(route('blog.edit',$post->id));
        $response->assertSessionHasErrors('message');
    }

    public function test_no_author_cant_update_post(){
        $post = Post::first();
        $fields = $post->toArray();
        $fields['title'] = $this->faker->text;
        $response = $this->actingAs($this->user)->patch(route('blog.update',$post->id), $fields);
        $response->assertSessionHasErrors('message');
    }

    public function test_no_author_cant_delete_post(){
        $post = Post::first();
        $response = $this->actingAs($this->user)->delete(route('blog.destroy',$post->id));
        $response->assertSessionHasErrors('message');
    }

    public function test_any_user_can_create_post(){
        $response = $this->actingAs($this->user)->get(route('blog.create'));
        $response->assertStatus(200);
    }

    public function test_any_user_can_store_post(){
        $post_data = Post::factory()->definition();
        $post_data['user_id'] = $this->user->id;

        $response = $this->actingAs($this->user)
            ->post(route('blog.store'),$post_data);
        $response->assertRedirect(route('blog.index'));
        $response->assertSessionDoesntHaveErrors();
    }



}