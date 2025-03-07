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
        $user = User::create([
            'role_id' => '1',
            'name' => 'Partnership',
            'password' => bcrypt('Jayaselalu28'),
        ]);
        $user = User::create([
            'role_id' => '2',
            'name' => 'Operator',
            'password' => bcrypt('Patrol'),
        ]);
        $user = User::create([
            'role_id' => '3',
            'name' => 'KCPatrol',
            'password' => bcrypt('Patrol'),
        ]);
    }
}
