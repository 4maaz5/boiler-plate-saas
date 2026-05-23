<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $panelUser = Role::firstOrCreate(['name' => 'panel_user', 'guard_name' => 'web']);

        $panelUser->syncPermissions(Permission::all());

        $saasAdmin = User::firstOrCreate(
            ['email' => 'admin@saas.com'],
            ['name' => 'SaaS Admin', 'password' => 'Admin@123'],
        );
        $saasAdmin->syncRoles(['super_admin']);

        $tenantAdmin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            ['name' => 'Admin', 'password' => 'Admin@123'],
        );
        $tenantAdmin->syncRoles(['panel_user']);
    }
}
