<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use App\Models\JobOffer;
use App\Models\ContractType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobOfferController extends Controller
{
    public function index()
    {
        $offers = JobOffer::query()
            ->where('recruiter_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('recruiter.offers.index', compact('offers'));
    }

    public function create()
    {
        $contractTypes = ContractType::query()->orderBy('name')->get();
        return view('recruiter.offers.create', compact('contractTypes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'contract_type_id' => ['required', 'exists:contract_types,id'],
            'title'            => ['required', 'string', 'max:255'],
            'place'            => ['required', 'string', 'max:255'],
            'start_date'       => ['nullable', 'date'],
            'description'      => ['required', 'string'],
            'image'            => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $path = $request->file('image')->store('job_offers', 'public');

        JobOffer::create([
            'recruiter_id'     => auth()->id(),
            'contract_type_id' => $data['contract_type_id'],
            'title'            => $data['title'],
            'place'            => $data['place'],
            'start_date'       => $data['start_date'] ?? null,
            'description'      => $data['description'],
            'image_path'       => $path,
        ]);

        return redirect()->route('recruiter.offers.index')->with('status', 'offer-created');
    }

    public function edit(JobOffer $offer)
    {
        abort_unless($offer->recruiter_id === auth()->id(), 403);

        $contractTypes = ContractType::query()->orderBy('name')->get();
        return view('recruiter.offers.edit', compact('offer', 'contractTypes'));
    }

    public function update(Request $request, JobOffer $offer)
    {
        abort_unless($offer->recruiter_id === auth()->id(), 403);

        $data = $request->validate([
            'contract_type_id' => ['required', 'exists:contract_types,id'],
            'title'            => ['required', 'string', 'max:255'],
            'place'            => ['required', 'string', 'max:255'],
            'start_date'       => ['nullable', 'date'],
            'description'      => ['required', 'string'],
            'image'            => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($offer->image_path);
            $offer->image_path = $request->file('image')->store('job_offers', 'public');
        }

        $offer->contract_type_id = $data['contract_type_id'];
        $offer->title            = $data['title'];
        $offer->place            = $data['place'];
        $offer->start_date       = $data['start_date'] ?? null;
        $offer->description      = $data['description'];
        $offer->save();

        return redirect()->route('recruiter.offers.index')->with('status', 'offer-updated');
    }

    public function close(JobOffer $offer)
    {
        abort_unless($offer->recruiter_id === auth()->id(), 403);

        $offer->update([
            'is_closed' => true,
            'closed_at' => now(),
        ]);

        return back()->with('status', 'offer-closed');
    }

    public function applications(JobOffer $offer)
    {
        abort_unless($offer->recruiter_id === auth()->id(), 403);

        $applications = $offer->applications()
            ->with(['employee.employeeProfile.speciality'])
            ->latest()
            ->paginate(15);

        return view('recruiter.offers.applications', compact('offer', 'applications'));
    }
}
