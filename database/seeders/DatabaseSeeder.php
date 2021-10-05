<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use App\Models\Label;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create(['name' => 'admin', 'password' => 'qweqweqwe', 'email' => 'test@test.test']);

        $users = User::factory(2)->create();

        foreach ($users as $user) {
            Task::factory(4)->create(['author_id' => $user->id]);
        }

        Label::factory(8)->create();
    }
}
