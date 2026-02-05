<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class BackfillUserProfiles extends Command
{
    protected $signature = 'profiles:backfill';
    protected $description = 'Create missing employee/recruiter profiles based on Spatie roles';

    public function handle(): int
    {
        $users = User::with(['employeeProfile', 'recruiterProfile'])->get();

        $createdEmployee = 0;
        $createdRecruiter = 0;

        foreach ($users as $user) {
            if ($user->hasRole('employee') && !$user->employeeProfile) {
                $user->employeeProfile()->create([
                    'speciality' => null,
                    'location'   => null,
                ]);
                $createdEmployee++;
            }

            if ($user->hasRole('recruiter') && !$user->recruiterProfile) {
                $user->recruiterProfile()->create([
                    'company_name' => null,
                    'website'      => null,
                    'location'     => null,
                ]);
                $createdRecruiter++;
            }
        }

        $this->info("Done Employee profile created: {$createdEmployee}");
        $this->info("Done Recruiter profile created: {$createdRecruiter}");

        return self::SUCCESS;
    }
}
