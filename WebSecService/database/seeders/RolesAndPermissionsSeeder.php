<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Clear existing permissions and roles
        DB::table('role_has_permissions')->delete();
        DB::table('model_has_roles')->delete();
        DB::table('model_has_permissions')->delete();
        DB::table('roles')->delete();
        DB::table('permissions')->delete();

        // Create permissions
        $permissions = [
            'manage products',
            'manage users',
            'add credit',
            'view credit history',
            'make purchases',
            'view purchase history'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles and assign permissions
        $admin = Role::create(['name' => 'Admin', 'guard_name' => 'web']);
        $admin->givePermissionTo([
            'manage products',
            'manage users',
            'add credit',
            'view credit history'
        ]);

        $employee = Role::create(['name' => 'Employee', 'guard_name' => 'web']);
        $employee->givePermissionTo([
            'manage products',
            'add credit',
            'view credit history'
        ]);

        $customer = Role::create(['name' => 'Customer', 'guard_name' => 'web']);
        $customer->givePermissionTo([
            'make purchases',
            'view purchase history'
        ]);

        // Create admin user if it doesn't exist
        if (!User::where('email', 'admin@admin.com')->exists()) {
            $admin = User::create([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('password'),
                'credit' => 0
            ]);
            $admin->assignRole('Admin');
        }
    }
} 