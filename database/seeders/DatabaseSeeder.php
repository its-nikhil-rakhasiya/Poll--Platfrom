<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'is_admin' => true,
        ]);

        $poll = \App\Models\Poll::create([
            'question' => 'What is your favorite framework?',
            'status' => 'active'
        ]);
        
        \App\Models\PollOption::create(['poll_id' => $poll->id, 'option_text' => 'Laravel']);
        \App\Models\PollOption::create(['poll_id' => $poll->id, 'option_text' => 'Symfony']);
        \App\Models\PollOption::create(['poll_id' => $poll->id, 'option_text' => 'Django']);
    }
}
