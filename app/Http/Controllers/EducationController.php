<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index()
    {
        $education = Education::all();
        return response()->json(['education' => $education]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'institution_name' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
        ]);
                                            
        Education::create($request->all());

        return response()->json(['success' => 'Education information added successfully.']);
    }

    public function show($id)
    {
        $education = Education::find($id);
        return response()->json(['education' => $education]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'institution_name' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
        ]);

        $education = Education::find($id);
        $education->update($request->all());

        return response()->json(['success' => 'Education information updated successfully.']);
    }

    public function destroy($id)
    {
        $education = Education::find($id);
        $education->delete();

        return response()->json(['success' => 'Education information deleted successfully.']);
    }
}
