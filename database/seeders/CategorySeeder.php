<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['name' => 'Rücken']);
        Category::create(['name' => 'Beine']);
        Category::create(['name' => 'Brust']);
        Category::create(['name' => 'Schultern']);
        Category::create(['name' => 'Bizeps']);
        Category::create(['name' => 'Trizeps']);
        Category::create(['name' => 'Bauch']); 
    }
}
