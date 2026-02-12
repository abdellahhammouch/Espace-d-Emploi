<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function checkout(Request $request)
    {
        $user = $request->user();

        // Optional: prevent double verification
        if ($user->is_verified) {
            return redirect()->back()->with('error', 'Already verified.');
        }

        $user->verification_requested_at = now();
        $user->verification_expires_at = now()->addMinutes(30);
        $user->save();

        return $user->checkout([
            [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Account Verification',
                    ],
                    'unit_amount' => 1000, // $10.00
                ],
                'quantity' => 1,
            ],
        ], [
            'success_url' => route('verification.success'),
            'cancel_url' => route('verification.cancel'),
        ]);
    }

    public function success()
    {
        return view('verification.success');
    }

    public function cancel()
    {
        return view('verification.cancel');
    }
}
