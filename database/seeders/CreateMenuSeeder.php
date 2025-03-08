<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create roles
        $admin = Role::create(['name' => 'admin']);
        $editor = Role::create(['name' => 'editor']);

        // Create permissions
        $manageUsersPermission = Permission::create(['name' => 'manage users']);
        $editArticlesPermission = Permission::create(['name' => 'edit articles']);
        $viewReportsPermission = Permission::create(['name' => 'view reports']);

        // Create parent menus
        $dashboardMenu = Menu::create(['name' => 'Dashboard', 'url' => '/admin/dashboard', 'icon' => 'dashboard-icon']);
        $managementMenu = Menu::create(['name' => 'Management', 'icon' => 'management-icon']); // No URL since it's a parent menu

        // Create submenus under "Management"
        $usersMenu = Menu::create(['name' => 'Users', 'url' => '/admin/users', 'parent_id' => $managementMenu->id]);
        $articlesMenu = Menu::create(['name' => 'Articles', 'url' => '/admin/articles', 'parent_id' => $managementMenu->id]);

        // Assign roles to menus
        $dashboardMenu->roles()->attach($admin);
        $managementMenu->roles()->attach($admin);
        $usersMenu->roles()->attach($admin);
        $articlesMenu->roles()->attach($editor);

        // Assign permissions to submenus
        $usersMenu->permissions()->attach($manageUsersPermission);
        $articlesMenu->permissions()->attach($editArticlesPermission);
    }
}
