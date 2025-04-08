<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'admin_users',
            'edit_users',
            'show_users',
            'delete_users',
            'manage_products',
            'manage_customers',
            'create_employees',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'Admin', 'guard_name' => 'web']);
        $adminRole->givePermissionTo(['admin_users', 'edit_users', 'show_users', 'delete_users', 'create_employees']);

        $employeeRole = Role::create(['name' => 'Employee', 'guard_name' => 'web']);
        $employeeRole->givePermissionTo(['manage_products', 'manage_customers']);

        $customerRole = Role::create(['name' => 'Customer', 'guard_name' => 'web']);
    }
}