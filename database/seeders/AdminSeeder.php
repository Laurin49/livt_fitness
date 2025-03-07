<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@hsv.de',
            'email_verified_at' => now(),
            'password' => bcrypt('hsv1887tv'),
            'remember_token' => Str::random(10),
        ])->assignRole('admin');

        User::create([
            'name' => 'polzin',
            'email' => 'polzin@hsv.de',
            'email_verified_at' => now(),
            'password' => bcrypt('hsv1887tv'),
            'remember_token' => Str::random(10),
        ])->assignRole('trainer');

        User::create([
            'name' => 'elfadli',
            'email' => 'elfadli@hsv.de',
            'email_verified_at' => now(),
            'password' => bcrypt('hsv1887tv'),
            'remember_token' => Str::random(10),
        ])->assignRole('user');

        User::create([
            'name' => 'welter',
            'email' => 'welter@diwe-dev.de',
            'email_verified_at' => now(),
            'password' => bcrypt('hsv1887tv'),
            'remember_token' => Str::random(10),
        ])->assignRole('user');
    }
}
