<?php

namespace Database\Seeders;

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
        Exercise::create(['name' => 'Bankdrücken L.H.']);
        Exercise::create(['name' => 'Schrägbankdrücken L.H.']);

        Exercise::create(['name' => 'Rudern Latzug SZ-Stange']);
        Exercise::create(['name' => 'Rudern Latzug enger Griff']);
        Exercise::create(['name' => 'Latziehen weiter Griff']);
        Exercise::create(['name' => 'Latziehen enger Griff']);

        Exercise::create(['name' => 'Seitheben KH']);
        Exercise::create(['name' => 'Seitheben Latzug']);
        Exercise::create(['name' => 'Seitheben Kabelzug reverse']);

        Exercise::create(['name' => 'Scottcurls Kabelzug SZ-Stange']);
        Exercise::create(['name' => 'Scottcurls Kabelzug K.H.']);
        Exercise::create(['name' => 'Scottcurls Kabelzug gerade Stange']);
        Exercise::create(['name' => 'Konzentrationscurls K.H.']);

        Exercise::create(['name' => 'Beinpresse']);
        Exercise::create(['name' => 'Beinbeuger']);
        Exercise::create(['name' => 'Beinstrecker']);

        Exercise::create(['name' => 'Trizepsdrücken Kabelzug SZ-Stange']);
        Exercise::create(['name' => 'Trizepsdrücken Kabelzug einarmig']);
        Exercise::create(['name' => 'Trizepsdrücken Kabelzug einarmig reverse']);
    }
}
