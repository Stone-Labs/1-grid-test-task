<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostRating;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RatingSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $post_ids = Post::select('id')->pluck('id');
        $user_ids = User::select('id')->pluck('id');

        foreach ($post_ids as $post_id){
            foreach ($user_ids as $user_id){
                $rating = rand(0,5);
                if($rating){
                    PostRating::create([
                        'user_id' => $user_id,
                        'post_id' => $post_id,
                        'rating' => $rating
                    ]);
                }
            }
        }
    }
}
