<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $sentence = $this->faker->sentence();
        $user = User::query()->inRandomOrder()->first();
        return [
            'user_id' => $user->id,
            'slug' => Str::slug($sentence),
            'title' => $sentence,
            'content' => $this->faker->realTextBetween(600, 1800),
        ];
    }
}
