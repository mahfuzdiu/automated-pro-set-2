<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //3 admins
        User::factory()->count(2)->admin()->create();

        //3 managers
        User::factory()->count(3)->organizer()->create();

        //5 users
        User::factory()->count(10)->create();
    }
}
