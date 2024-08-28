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
        return $this->getAllProjects();
    }

    public function store(Request $request)
    {
        return $this->createProject($request);
    }

    public function show(string $id)
    {
        return $this->getProjectById($id);
    }

    public function update(Request $request)
    {
        return $this->updateProject($request);
    }

    public function delete(Request $request)
    {
        return $this->deleteProject($request);
    }

    private function getAllProjects()
    {
        $projects = Project::all();
        return response()->json($projects, Response::HTTP_OK);
    }

    private function createProject(Request $request)
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

    private function getProjectById(string $id)
    {
        $project = Project::findOrFail($id);
        return response()->json($project, Response::HTTP_OK);
    }

    private function updateProject(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|string|exists:projects,id',
            'name' => 'sometimes|string|max:255',
            'department' => 'sometimes|string|max:255',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after_or_equal:start_date',
            'status' => 'sometimes|string|max:255',
        ]);

        $project = Project::findOrFail($validatedData['id']);
        $project->update($validatedData);

        return response()->json($project, Response::HTTP_OK);
    }

    private function deleteProject(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|string|exists:projects,id',
        ]);

        $project = Project::findOrFail($validatedData['id']);

        Timesheet::where('project_id', $validatedData['id'])->delete();

        $project->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
