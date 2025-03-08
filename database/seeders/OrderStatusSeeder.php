<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_status')->insert([
            ['status_name' => 'New', 'description' => 'Order has been placed but not yet processed.'],
            ['status_name' => 'Packed', 'description' => 'Order has been confirmed and packed.'],
            ['status_name' => 'Processing', 'description' => 'Order is being prepared or packed for shipment.'],
            ['status_name' => 'Shipped', 'description' => 'Order has been shipped and is on its way.'],
            ['status_name' => 'Delivered', 'description' => 'Order has been successfully delivered to the customer.'],
            ['status_name' => 'Cancelled', 'description' => 'Order has been cancelled either by the customer or the admin.'],
        ]);
    }
}
