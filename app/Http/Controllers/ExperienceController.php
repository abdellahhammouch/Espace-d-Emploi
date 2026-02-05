<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'job_title'       => ['required','string','max:255'],
            'company'         => ['required','string','max:255'],
            'employment_type' => ['nullable','string','max:255'],
            'start_date'      => ['nullable','date'],
            'end_date'        => ['nullable','date'],
            'is_current'      => ['nullable','boolean'],
            'description'     => ['nullable','string'],
        ]);

        $profile = $request->user()->employeeProfile()->firstOrCreate([
            'user_id' => $request->user()->id,
        ]);

        // si is_current = true => end_date null (logique LinkedIn)
        if (!empty($data['is_current'])) {
            $data['end_date'] = null;
        }

        $profile->experiences()->create($data);

        return back()->with('status', 'experience-added');
    }

    public function update(Request $request, Experience $experience)
    {
        // sécurité: tu modifies seulement tes expériences
        abort_unless($experience->employeeProfile->user_id === $request->user()->id, 403);

        $data = $request->validate([
            'job_title'       => ['required','string','max:255'],
            'company'         => ['required','string','max:255'],
            'employment_type' => ['nullable','string','max:255'],
            'start_date'      => ['nullable','date'],
            'end_date'        => ['nullable','date'],
            'is_current'      => ['nullable','boolean'],
            'description'     => ['nullable','string'],
        ]);

        if (!empty($data['is_current'])) {
            $data['end_date'] = null;
        }

        $experience->update($data);

        return back()->with('status', 'experience-updated');
    }

    public function destroy(Request $request, Experience $experience)
    {
        abort_unless($experience->employeeProfile->user_id === $request->user()->id, 403);

        $experience->delete();

        return back()->with('status', 'experience-deleted');
    }
}

?>