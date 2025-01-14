<?php

namespace Database\Seeders;

use App\Models\Workout;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Workout::create(['name' => 'Rückentraining']);
        Workout::create(['name' => 'Brusttraining']);
        Workout::create(['name' => 'Schultertraining']);
        Workout::create(['name' => 'Bizepstraining']);
        Workout::create(['name' => 'Tripeztraining']);
        Workout::create(['name' => 'Beintraining']);
    }
}
