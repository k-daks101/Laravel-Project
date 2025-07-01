<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opportunity;

class OpportunityController extends Controller

{
    // GET /api/opportunities
    public function index()
    {
        return response()->json(Opportunity::all(), 200);
    }

    // GET /api/opportunities/{id}
    public function show($id)
    {
        $opportunity = Opportunity::find($id);

        if (!$opportunity) {
            return response()->json(['message' => 'Opportunity not found'], 404);
        }

        return response()->json($opportunity, 200);
    }

    // POST /api/opportunities
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'url' => 'required|url',
            'qualification' => 'nullable|string',
            'region' => 'nullable|string',
            'deadline' => 'nullable|date',
            'type' => 'required|in:Scholarship,Job,Training'
        ]);

        $opportunity = Opportunity::create($validated);

        return response()->json([
            'message' => 'Opportunity created successfully',
            'data' => $opportunity
        ], 201);
    }

    // PUT /api/opportunities/{id}
    public function update(Request $request, $id)
    {
        $opportunity = Opportunity::find($id);

        if (!$opportunity) {
            return response()->json(['message' => 'Opportunity not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string',
            'description' => 'nullable|string',
            'url' => 'sometimes|required|url|unique:opportunities,url', //ensures uniqueness
            'qualification' => 'nullable|string',
            'region' => 'nullable|string',
            'deadline' => 'nullable|date',
            'type' => 'sometimes|required|in:Scholarship,Job,Training'
        ]);

        $opportunity->update($validated);

        return response()->json([
            'message' => 'Opportunity updated successfully',
            'data' => $opportunity
        ], 200);
    }

    // DELETE /api/opportunities/{id}
    public function destroy($id)
    {
        $opportunity = Opportunity::find($id);

        if (!$opportunity) {
            return response()->json(['message' => 'Opportunity not found'], 404);
        }

        $opportunity->delete();

        return response()->json(['message' => 'Opportunity deleted successfully'], 200);
    }
}

