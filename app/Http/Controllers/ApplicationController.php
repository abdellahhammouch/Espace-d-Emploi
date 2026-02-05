<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobOffer;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function store(Request $request, JobOffer $offer)
    {
        abort_if($offer->is_closed, 403, 'Offre clôturée.');

        $data = $request->validate([
            'note' => ['nullable', 'string', 'max:2000'],
        ]);

        Application::firstOrCreate(
            [
                'job_offer_id' => $offer->id,
                'employee_id'  => auth()->id(),
            ],
            [
                'status' => 'pending',
                'note'   => $data['note'] ?? null,
            ]
        );

        return back()->with('status', 'application-sent');
    }
}
