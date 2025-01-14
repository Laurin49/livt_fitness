<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Workout;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;

class WorkoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datum = date('Y-m-d');

        $brust_category = Category::where('name', 'Brust')->first()->id;
        $ruecken_category = Category::where('name', 'Rücken')->first()->id;
        $schulter_category = Category::where('name', 'Schultern')->first()->id;
        $bizeps_category = Category::where('name', 'Bizeps')->first()->id;
        $trizeps_category = Category::where('name', 'Trizeps')->first()->id;
        $bein_category = Category::where('name', 'Beine')->first()->id;
        
        Workout::create(['name' => 'Rückentraining', 'datum' => $this->addDays($datum, 1), 'category_id' => $ruecken_category]);
        Workout::create(['name' =>'Brusttraining', 'datum' => $this->addDays($datum, 1), 'category_id' => $brust_category]);
        Workout::create(['name' => 'Schultertraining', 'datum' => $this->addDays($datum, 2), 'category_id' => $schulter_category]);
        Workout::create(['name' => 'Bizepstraining', 'datum' => $this->addDays($datum, 3), 'category_id' => $bizeps_category]);
        Workout::create(['name' => 'Tripeztraining', 'datum' => $this->addDays($datum, 3), 'category_id' => $trizeps_category]);
        Workout::create(['name' => 'Beintraining', 'datum' => $this->addDays($datum, 4), 'category_id' => $bein_category]);
        Workout::create(['name' => 'Wadentraining', 'datum' => $this->addDays($datum, 4), 'category_id' => $bein_category]);
    }

    private function addDays($datum, $days)
    {
        $anzahl_tage = $days . ' day';
        $result = date('Y-m-d', strtotime($anzahl_tage, strtotime($datum)));
        return $result;
    }
}
