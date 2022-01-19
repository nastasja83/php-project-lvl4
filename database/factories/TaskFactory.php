<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Task;
use Illuminate\Support\Str;
use App\Models\TaskStatus;
use App\Models\User;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $status = TaskStatus::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();
        $executor = User::inRandomOrder()->first();

        return [
            'name' => $this->faker->name(),
            'description' => Str::random(10),
            'status_id' => $status->id,
            'created_by_id' => $user->id,
            'assigned_to_id' => $executor->id
        ];
    }
}
