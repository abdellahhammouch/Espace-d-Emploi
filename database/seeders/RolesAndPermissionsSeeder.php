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

        $permissions = [
            // Offres
            'offer.view',
            'offer.create',
            'offer.update',
            'offer.close',

            // Candidatures
            'application.apply',
            'application.view_received',
            'application.view_own',

            // Profil/CV
            'profile.edit',
            'cv.edit',

            // Réseau
            'friend.request',
            'friend.accept',
            'friend.decline',
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate([
                'name' => $p,
                'guard_name' => 'web',
            ]);
        }

        $recruiter = Role::firstOrCreate(['name' => 'recruiter', 'guard_name' => 'web']);
        $employee  = Role::firstOrCreate(['name' => 'employee',  'guard_name' => 'web']);

        $recruiter->syncPermissions([
            'offer.view', 'offer.create', 'offer.update', 'offer.close',
            'application.view_received',
            'profile.edit',
            'friend.request','friend.accept','friend.decline',
        ]);

        $employee->syncPermissions([
            'offer.view',
            'application.apply', 'application.view_own',
            'profile.edit','cv.edit',
            'friend.request','friend.accept','friend.decline',
        ]);
    }
}
