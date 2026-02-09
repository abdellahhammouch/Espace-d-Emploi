<?php

namespace Database\Seeders;

use App\Models\JobOffer;
use App\Models\User;
use App\Models\RecruiterProfile;
use Illuminate\Database\Seeder;

class JobOfferSeeder extends Seeder
{
    public function run(): void
    {
        $recruiters = User::role('recruiter')->get();

        if ($recruiters->count() < 5) {
            $missing = 5 - $recruiters->count();

            $newRecruiters = User::factory()->count($missing)->create();
            foreach ($newRecruiters as $u) {
                $u->assignRole('recruiter');

                RecruiterProfile::updateOrCreate(
                    ['user_id' => $u->id],
                    [
                        'company_name' => fake()->company(),
                        'website' => fake()->url(),
                        'location' => fake()->city(),
                    ]
                );
            }

            $recruiters = User::role('recruiter')->get();
        }

        $recruiterIds = $recruiters->pluck('id');

        JobOffer::factory()
            ->count(30)
            ->create([
                'recruiter_id' => fn() => $recruiterIds->random(),
            ]);
    }
}
