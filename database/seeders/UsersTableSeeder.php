<?php

namespace Database\Seeders;
 
namespace Database\Seeders;
 
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        User::create([
            'name' => 'admin',
            'user_id' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678')
        ]);
        
    }
}
