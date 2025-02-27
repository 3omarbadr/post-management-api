<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'create posts',
            'edit posts',
            'delete posts',
            'publish posts',
            'manage users',
            'manage roles'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'api']);
        }

        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'api']);
        $adminRole->givePermissionTo(Permission::all());

        $editorRole = Role::create(['name' => 'editor', 'guard_name' => 'api']);
        $editorRole->givePermissionTo(['create posts', 'edit posts', 'publish posts']);

        $userRole = Role::create(['name' => 'user', 'guard_name' => 'api']);
        $userRole->givePermissionTo(['create posts', 'edit posts']);
    }
}
