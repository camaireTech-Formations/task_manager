<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'task_name' => $this->faker->sentence(3),
            'details' => $this->faker->paragraph(),
            'tasks_list_id' => random_int(1,5),
            'statut' => $this->faker->randomElement([1,2,3]),
        ];
    }
}
