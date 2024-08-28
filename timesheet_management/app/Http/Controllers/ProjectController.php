<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Timesheet;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return response()->json($projects, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string|max:255',
        ]);

        $project = Project::create($validatedData);
        return response()->json($project, Response::HTTP_CREATED);
    }

    public function show(string $id)
    {
        $project = Project::findOrFail($id);
        return response()->json($project, Response::HTTP_OK);
    }

    public function update(Request $request, string $id)
    {
        $project = Project::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'department' => 'string|max:255',
            'start_date' => 'date',
            'end_date' => 'date|after_or_equal:start_date',
            'status' => 'string|max:255',
        ]);

        $project->update($validatedData);
        return response()->json($project, Response::HTTP_OK);
    }

    public function delete(Request $request, string $id)
    {
        $project = Project::findOrFail($id);

        Timesheet::where('project_id', $id)->delete();

        $project->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
