<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $guard = config('auth.defaults.guard', 'web');

        $permissions = [
            'offer.view',
            'offer.create',
            'offer.update',
            'offer.delete',
            'offer.close',

            'application.create',
            'application.view_own',
            'application.view_received',

            'cv.view_own',
            'cv.edit_own',
        ];

        foreach ($permissions as $name) {
            Permission::firstOrCreate([
                'name' => $name,
                'guard_name' => $guard,
            ]);
        }

        $recruiter = Role::firstOrCreate(['name' => 'recruiter', 'guard_name' => $guard]);
        $employee  = Role::firstOrCreate(['name' => 'employee',  'guard_name' => $guard]);

        $recruiter->syncPermissions([
            'offer.view',
            'offer.create',
            'offer.update',
            'offer.delete',
            'offer.close',
            'application.view_received',
        ]);

        $employee->syncPermissions([
            'offer.view',
            'application.create',
            'application.view_own',
            'cv.view_own',
            'cv.edit_own',
        ]);
    }
}
