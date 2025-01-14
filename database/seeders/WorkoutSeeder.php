<?php

namespace Database\Seeders;

use App\Models\Category;
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
        $brust_category = Category::where('name', 'Brust')->first()->id;
        $ruecken_category = Category::where('name', 'Rücken')->first()->id;
        $schulter_category = Category::where('name', 'Schultern')->first()->id;
        $bizeps_category = Category::where('name', 'Bizeps')->first()->id;
        $trizeps_category = Category::where('name', 'Trizeps')->first()->id;
        $bein_category = Category::where('name', 'Beine')->first()->id;
        
        Workout::create(['name' => 'Rückentraining', 'category_id' => $ruecken_category]);
        Workout::create(['name' =>'Brusttraining', 'category_id' => $brust_category]);
        Workout::create(['name' => 'Schultertraining', 'category_id' => $schulter_category]);
        Workout::create(['name' => 'Bizepstraining', 'category_id' => $bizeps_category]);
        Workout::create(['name' => 'Tripeztraining', 'category_id' => $trizeps_category]);
        Workout::create(['name' => 'Beintraining', 'category_id' => $bein_category]);
        Workout::create(['name' => 'Wadentraining', 'category_id' => $bein_category]);
    }
}
