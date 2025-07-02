<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opportunity;

class OpportunityController extends Controller

{
    // GET /api/opportunities
    public function index(Request $request)

    {
        $query = Opportunity::query();

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('region')) {
            $query->where('country_region', $request->region);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status); // Add 'status' column to the table if needed
        }

        return response()->json($query->get(), 200);
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
            'county_region' => 'nullable|string',
            'deadline' => 'nullable|date',
            'type' => 'required|in:Scholarship,Job,Training',
            'status' => 'required|in:active,closed,expired'

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
            'region' => 'nullable|string',
            'deadline' => 'nullable|date',
            'type' => 'sometimes|required|in:Scholarship,Job,Training',
            'status' => 'sometimes|required|in:active,closed,expired'

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
