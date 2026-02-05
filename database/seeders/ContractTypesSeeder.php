<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContractTypesSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $types = [
            ['name' => 'CDI',       'created_at' => $now, 'updated_at' => $now],
            ['name' => 'CDD',       'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Full-time', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Part-time', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Stage',     'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Freelance', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('contract_types')->upsert(
            $types,
            ['name'],
            ['updated_at']
        );
    }
}
