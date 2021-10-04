<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use App\Models\TaskStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'author_id' => User::factory(),
            'status_id' => TaskStatus::factory(),
            'assigned_to_id' => User::factory(),
            'name'=>  $this->faker->text(20),
            'description' =>  $this->faker->paragraph()
        ];
    }

}
