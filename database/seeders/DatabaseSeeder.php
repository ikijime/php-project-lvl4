<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use App\Models\Label;
use App\Models\TaskStatus;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $faker = FakerFactory::create();

        User::factory()->create(['name' => 'admin', 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'email' => 'test@test.test']);

        $users = User::factory(2)->create();
        TaskStatus::factory(4)->create();
        Label::factory(6)->create();

        foreach (User::all() as $user) {
            for ($i = 0; $i < 2; $i++) {
                $taskData[] = [
                    'name' => $faker->unique()->word(),
                    'author_id' =>  $user->id,
                    'assigned_to_id' => User::inRandomOrder()->get('id')->first()->id,
                    'status_id' => rand(1, 4),
                    'description' => Str::random(20),
                    'created_at' => now()->toDateTimeString(),
                    'updated_at' => now()->toDateTimeString()
                ];

                Task::insert($taskData);
            }
        }
    }
}
