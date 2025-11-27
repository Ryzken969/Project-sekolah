<?php

namespace Database\Factories;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TodoFactory extends Factory
{
    protected $model = Todo::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(2),
            'status' => $this->faker->randomElement(['todo', 'doing', 'done']),
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
