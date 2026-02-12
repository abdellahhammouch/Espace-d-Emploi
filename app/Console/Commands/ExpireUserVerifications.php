<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ExpireUserVerifications extends Command
{
    protected $signature = 'users:expire-verifications';
    protected $description = 'Unverify users whose verification has expired';

    public function handle()
    {
        $count = User::where('is_verified', true)
            ->whereNotNull('verification_expires_at')
            ->where('verification_expires_at', '<', now())
            ->update([
                'is_verified' => false,
            ]);

        $this->info("Expired verifications for {$count} users.");
    }
}