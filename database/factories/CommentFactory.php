<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Factories\Factory;
use phpDocumentor\Reflection\Types\Parent_;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'content' => $this->faker->text,
            'created_at' => $this->faker->dateTimeBetween('-3 months'),
        ];
    }
}

// $factory->define(App\Models\Comment::class, function (Faker $faker) {
//     return [
//         'content' => $this->faker->text,
//     ];
// });