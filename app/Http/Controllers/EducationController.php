<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'degree'     => ['required','string','max:255'],
            'school'     => ['required','string','max:255'],
            'field'      => ['nullable','string','max:255'],
            'start_year' => ['nullable','integer','min:1900','max:2100'],
            'end_year'   => ['nullable','integer','min:1900','max:2100'],
        ]);

        $profile = $request->user()->employeeProfile()->firstOrCreate([
            'user_id' => $request->user()->id,
        ]);

        $profile->educations()->create($data);

        return back()->with('status', 'education-added');
    }

    public function update(Request $request, Education $education)
    {
        abort_unless($education->employeeProfile->user_id === $request->user()->id, 403);

        $data = $request->validate([
            'degree'     => ['required','string','max:255'],
            'school'     => ['required','string','max:255'],
            'field'      => ['nullable','string','max:255'],
            'start_year' => ['nullable','integer','min:1900','max:2100'],
            'end_year'   => ['nullable','integer','min:1900','max:2100'],
        ]);

        $education->update($data);

        return back()->with('status', 'education-updated');
    }

    public function destroy(Request $request, Education $education)
    {
        abort_unless($education->employeeProfile->user_id === $request->user()->id, 403);

        $education->delete();

        return back()->with('status', 'education-deleted');
    }
}
