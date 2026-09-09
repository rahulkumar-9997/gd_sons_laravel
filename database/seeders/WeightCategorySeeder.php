<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\WeightCategory;

class WeightCategorySeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('pincode_shipping_rates')->truncate();
        DB::table('weight_categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $now = now();
        WeightCategory::insert([
    ['primary_weight' => 0.5,  'min_weight' => 0.00,  'max_weight' => 0.50,  'created_at' => $now, 'updated_at' => $now],
    ['primary_weight' => 1,    'min_weight' => 0.51,  'max_weight' => 1.00,  'created_at' => $now, 'updated_at' => $now],
    ['primary_weight' => 2,    'min_weight' => 1.01,  'max_weight' => 2.00,  'created_at' => $now, 'updated_at' => $now],
    ['primary_weight' => 3,    'min_weight' => 2.01,  'max_weight' => 3.00,  'created_at' => $now, 'updated_at' => $now],
    ['primary_weight' => 4,    'min_weight' => 3.01,  'max_weight' => 4.00,  'created_at' => $now, 'updated_at' => $now],
    ['primary_weight' => 5,    'min_weight' => 4.01,  'max_weight' => 5.00,  'created_at' => $now, 'updated_at' => $now],
    ['primary_weight' => 7.5,  'min_weight' => 5.01,  'max_weight' => 7.50,  'created_at' => $now, 'updated_at' => $now],
    ['primary_weight' => 10,   'min_weight' => 7.51,  'max_weight' => 10.00, 'created_at' => $now, 'updated_at' => $now],
    ['primary_weight' => 15,   'min_weight' => 10.01, 'max_weight' => 15.00, 'created_at' => $now, 'updated_at' => $now],
    ['primary_weight' => 25,   'min_weight' => 15.01, 'max_weight' => 25.00, 'created_at' => $now, 'updated_at' => $now],
    ['primary_weight' => 50,   'min_weight' => 25.01, 'max_weight' => null,  'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
