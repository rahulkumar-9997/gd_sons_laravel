<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pincode;

class PincodeSeeder extends Seeder
{
    public function run(): void
    {
        $file = storage_path('app/pincodes.csv');
        if (!file_exists($file)) {
            return;
        }
        $handle = fopen($file, 'r');
        fgetcsv($handle);
        $rows = [];
        while (($row = fgetcsv($handle)) !== false) {
            $rows[] = [
                'pincode'   => trim($row[0]),
                'district'  => trim($row[1]),
                'state'     => trim($row[2]),
                'created_at'=> now(),
                'updated_at'=> now(),
            ];
        }
        fclose($handle);
        Pincode::upsert(
            $rows,
            ['pincode'],
            ['district', 'state']
        );
    }
}