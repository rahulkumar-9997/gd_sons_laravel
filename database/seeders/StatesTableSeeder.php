<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesTableSeeder extends Seeder
{
    public function run()
    {
        $states = [
            // -------- STATES (28) --------
            ['name' => 'Andhra Pradesh', 'type' => 'State'],
            ['name' => 'Arunachal Pradesh', 'type' => 'State'],
            ['name' => 'Assam', 'type' => 'State'],
            ['name' => 'Bihar', 'type' => 'State'],
            ['name' => 'Chhattisgarh', 'type' => 'State'],
            ['name' => 'Goa', 'type' => 'State'],
            ['name' => 'Gujarat', 'type' => 'State'],
            ['name' => 'Haryana', 'type' => 'State'],
            ['name' => 'Himachal Pradesh', 'type' => 'State'],
            ['name' => 'Jharkhand', 'type' => 'State'],
            ['name' => 'Karnataka', 'type' => 'State'],
            ['name' => 'Kerala', 'type' => 'State'],
            ['name' => 'Madhya Pradesh', 'type' => 'State'],
            ['name' => 'Maharashtra', 'type' => 'State'],
            ['name' => 'Manipur', 'type' => 'State'],
            ['name' => 'Meghalaya', 'type' => 'State'],
            ['name' => 'Mizoram', 'type' => 'State'],
            ['name' => 'Nagaland', 'type' => 'State'],
            ['name' => 'Odisha', 'type' => 'State'],
            ['name' => 'Punjab', 'type' => 'State'],
            ['name' => 'Rajasthan', 'type' => 'State'],
            ['name' => 'Sikkim', 'type' => 'State'],
            ['name' => 'Tamil Nadu', 'type' => 'State'],
            ['name' => 'Telangana', 'type' => 'State'],
            ['name' => 'Tripura', 'type' => 'State'],
            ['name' => 'Uttar Pradesh', 'type' => 'State'],
            ['name' => 'Uttarakhand', 'type' => 'State'],
            ['name' => 'West Bengal', 'type' => 'State'],

            // -------- UNION TERRITORIES (8) --------
            ['name' => 'Andaman and Nicobar Islands', 'type' => 'Union Territory'],
            ['name' => 'Chandigarh', 'type' => 'Union Territory'],
            ['name' => 'Dadra and Nagar Haveli and Daman and Diu', 'type' => 'Union Territory'],
            ['name' => 'Delhi', 'type' => 'Union Territory'],
            ['name' => 'Jammu and Kashmir', 'type' => 'Union Territory'],
            ['name' => 'Ladakh', 'type' => 'Union Territory'],
            ['name' => 'Lakshadweep', 'type' => 'Union Territory'],
            ['name' => 'Puducherry', 'type' => 'Union Territory'],
        ];

        DB::table('states')->insert($states);
    }
}
