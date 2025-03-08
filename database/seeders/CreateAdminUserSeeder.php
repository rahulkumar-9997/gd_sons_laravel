<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Admin', 
            'user_id' => 'Admin', 
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        // $role = Role::create(['name' => 'admin']);
        $roleName = 'admin';
        $role = Role::firstOrCreate(['name' => $roleName]);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}