<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Bruno Roberto Gomes',
            'email' => 'bruno@brgomes.com',
            //'password' => 'password', é a senha padrão (não precisa da class Hash)
            'active' => true,
        ]);
    }
}
