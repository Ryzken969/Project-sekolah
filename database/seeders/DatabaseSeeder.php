<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Todo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create user dengan password fix
        $user = User::create([
            'name' => 'Rafi Test',
            'email' => 'rafi@example.com',
            'password' => Hash::make('password123'), // password yang dipakai login
        ]);

        // Create sample todos
        Todo::factory()->count(5)->create([
            'user_id' => $user->id,
            'status' => 'todo',
        ]);

        Todo::factory()->count(3)->create([
            'user_id' => $user->id,
            'status' => 'doing',
        ]);

        Todo::factory()->count(2)->create([
            'user_id' => $user->id,
            'status' => 'done',
        ]);
    }
}
