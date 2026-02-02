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
            'offer.create',
            'offer.update',
            'offer.close',
            'offer.view',

            'application.apply',
            'application.view_own',
            'application.view_received',

            'cv.edit_own',
            'cv.view_own',
        ];

        // 4) Créer les permissions (sans doublons)
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => $guard,
            ]);
        }

        $recruiter = Role::firstOrCreate(['name' => 'recruiter', 'guard_name' => $guard]);
        $employee  = Role::firstOrCreate(['name' => 'employee',  'guard_name' => $guard]);

        $recruiter->syncPermissions([
            'offer.create',
            'offer.update',
            'offer.close',
            'offer.view',
            'application.view_received',
        ]);

        $employee->syncPermissions([
            'offer.view',
            'application.apply',
            'application.view_own',
            'cv.edit_own',
            'cv.view_own',
        ]);

        // (optionnel) si tu veux que admin ait tout :
        // $admin->syncPermissions(Permission::where('guard_name', $guard)->get());
    }
}
