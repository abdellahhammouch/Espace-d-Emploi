<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class StripeController extends Controller
{
    public function checkout(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $paymentIntent = PaymentIntent::create([
            'amount' => 1000, // Amount in cents ($10)
            'currency' => 'usd',
        ]);

        return response()->json([
            'client_secret' => $paymentIntent->client_secret
        ]);
    }
}
