<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Timesheet;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ProjectController extends Controller
{
    public function index()
    {
        try {
            return $this->getAllProjects();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving projects',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request)
    {
        try {
            return $this->createProject($request);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Failed',
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating the project',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(string $id)
    {
        try {
            return $this->getProjectById($id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving the project',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request)
    {
        return $this->updateProject($request);
    }

    public function delete(Request $request)
    {
        try {
            return $this->deleteProject($request);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Failed',
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the project',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function getAllProjects()
    {
        $projects = Project::with(['users', 'timesheets'])->get();
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
        $project = Project::with(['users', 'timesheets'])->findOrFail($id);
        return response()->json($project, Response::HTTP_OK);
    }

    private function updateProject(Request $request)
    {
        try {
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
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Failed',
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the project',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function deleteProject(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id' => 'required|string|exists:projects,id',
            ]);

            $project = Project::findOrFail($validatedData['id']);

            Timesheet::where('project_id', $validatedData['id'])->delete();

            $project->delete();

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Failed',
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the project',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
