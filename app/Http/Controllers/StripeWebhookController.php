<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends CashierController
{
    /**
     * Handle Stripe webhook events
     */
    public function handleWebhook(Request $request)
    {
        $payload = $request->all();

        Log::info('Stripe webhook received', ['payload' => $payload]);

        return parent::handleWebhook($request);
    }

    /**
     * Handle checkout.session.completed
     */
    public function handleCheckoutSessionCompleted($payload)
    {
        $session = $payload['data']['object'];

        Log::info('Stripe checkout.session.completed received', ['session' => $session]);

        $stripeCustomerId = $session['customer'] ?? null;

        $user = User::where('stripe_id', $stripeCustomerId)->first();

        if ($user) {
            $user->update([
                'is_verified' => true,
                'verification_expires_at' => now()->addDays(30),
            ]);

            Log::info("User {$user->id} verified successfully via Stripe.");
        } else {
            Log::warning('Stripe webhook: User not found for customer', ['customer' => $stripeCustomerId]);
        }

        return response()->json(['status' => 'success']);
    }
}
