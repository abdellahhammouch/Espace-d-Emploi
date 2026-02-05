<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use App\Models\ContractType;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->string('q')->toString();
        $contractTypeId = $request->integer('contract_type_id');

        $offers = JobOffer::query()
            ->with(['recruiter.recruiterProfile', 'contractType'])
            ->where('is_closed', false)
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('title', 'ilike', "%{$q}%")
                        ->orWhere('place', 'ilike', "%{$q}%")
                        ->orWhere('description', 'ilike', "%{$q}%");
                });
            })
            ->when($contractTypeId, fn($query) => $query->where('contract_type_id', $contractTypeId))
            ->latest()
            ->paginate(9)
            ->withQueryString();

        $contractTypes = ContractType::query()->orderBy('name')->get();

        return view('offers.index', compact('offers', 'contractTypes', 'q', 'contractTypeId'));
    }

    public function show(JobOffer $offer)
    {
        $offer->load(['recruiter.recruiterProfile', 'contractType']);

        $applied = false;
        if (auth()->check() && auth()->user()->hasRole('employee')) {
            $applied = $offer->applications()
                ->where('employee_id', auth()->id())
                ->exists();
        }

        return view('offers.show', compact('offer', 'applied'));
    }
}
