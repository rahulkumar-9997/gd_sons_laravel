<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WeightCategory;
class WeightCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WeightCategory::insert([
            ['primary_weight'=>0.5,'min_weight'=>0.00,'max_weight'=>0.49],
            ['primary_weight'=>1,'min_weight'=>0.50,'max_weight'=>0.99],
            ['primary_weight'=>1.5,'min_weight'=>1.00,'max_weight'=>1.49],
            ['primary_weight'=>2,'min_weight'=>1.50,'max_weight'=>1.99],
            ['primary_weight'=>3,'min_weight'=>2.00,'max_weight'=>2.99],
            ['primary_weight'=>5,'min_weight'=>3.00,'max_weight'=>4.99],
            ['primary_weight'=>10,'min_weight'=>5.00,'max_weight'=>9.99],
            ['primary_weight'=>15,'min_weight'=>10.00,'max_weight'=>14.99],
            ['primary_weight'=>20,'min_weight'=>15.00,'max_weight'=>19.99],
            ['primary_weight'=>25,'min_weight'=>20.00,'max_weight'=>24.99],
            ['primary_weight'=>30,'min_weight'=>25.00,'max_weight'=>29.99],
            ['primary_weight'=>40,'min_weight'=>30.00,'max_weight'=>39.99],
            ['primary_weight'=>40,'min_weight'=>40.00,'max_weight'=>null],
        ]);
    }
}
