<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Exercise;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExerciseSeeder extends Seeder
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

        Exercise::create(['name' => 'Bankdrücken L.H.', 'category_id' => $brust_category]);
        Exercise::create(['name' => 'Schrägbankdrücken L.H.', 'category_id' => $brust_category]);

        Exercise::create(['name' => 'Rudern Latzug SZ-Stange', 'category_id' => $ruecken_category]);
        Exercise::create(['name' => 'Rudern Latzug enger Griff', 'category_id' => $ruecken_category]);
        Exercise::create(['name' => 'Latziehen weiter Griff', 'category_id' => $ruecken_category]);
        Exercise::create(['name' => 'Latziehen enger Griff', 'category_id' => $ruecken_category]);

        Exercise::create(['name' => 'Seitheben KH', 'category_id' => $schulter_category]);
        Exercise::create(['name' => 'Seitheben Latzug', 'category_id' => $schulter_category]);
        Exercise::create(['name' => 'Seitheben Kabelzug reverse', 'category_id' => $schulter_category]);

        Exercise::create(['name' => 'Scottcurls Kabelzug SZ-Stange', 'category_id' => $bizeps_category]);
        Exercise::create(['name' => 'Scottcurls Kabelzug K.H.', 'category_id' => $bizeps_category]);
        Exercise::create(['name' => 'Scottcurls Kabelzug gerade Stange', 'category_id' => $bizeps_category]);
        Exercise::create(['name' => 'Konzentrationscurls K.H.', 'category_id' => $bizeps_category]);

        Exercise::create(['name' => 'Beinpresse', 'category_id' => $bein_category]);
        Exercise::create(['name' => 'Beinbeuger', 'category_id' => $bein_category]);
        Exercise::create(['name' => 'Beinstrecker', 'category_id' => $bein_category]);

        Exercise::create(['name' => 'Trizepsdrücken Kabelzug SZ-Stange', 'category_id' => $trizeps_category]);
        Exercise::create(['name' => 'Trizepsdrücken Kabelzug einarmig', 'category_id' => $trizeps_category]);
        Exercise::create(['name' => 'Trizepsdrücken Kabelzug einarmig reverse', 'category_id' => $trizeps_category]);
    }
}
