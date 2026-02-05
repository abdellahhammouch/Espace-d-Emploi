<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialitiesSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $specialities = [
            ['name' => 'Développeur Fullstack', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Développeur Back-end', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Développeur Front-end', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Développeur Laravel', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Développeur React', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'UI/UX Designer', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Comptable', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Chef de projet', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Data Analyst', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'DevOps', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('specialities')->upsert(
            $specialities,
            ['name'],
            ['updated_at']
        );
    }
}
