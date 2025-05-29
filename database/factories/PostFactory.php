<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraphs(3, true),
            'image_url' => $this->faker->optional()->imageUrl(),
            'scheduled_time' => $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            'status' => Arr::random(['draft', 'scheduled', 'published']),
            'user_id' => \App\Models\User::factory(),
            'created_at' => $this->faker->dateTimeThisYear(),
            'updated_at' => now(),
        ];
    }
}