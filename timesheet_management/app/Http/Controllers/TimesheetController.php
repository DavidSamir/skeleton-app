<?php

namespace App\Http\Controllers;

use App\Models\Timesheet;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class TimesheetController extends Controller
{
    public function index()
    {
        try {
            return $this->getAllTimesheets();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving timesheets',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request)
    {
        try {
            return $this->createTimesheet($request);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Failed',
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating the timesheet',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(string $id)
    {
        try {
            return $this->getTimesheetById($id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving the timesheet',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request)
    {
        return $this->updateTimesheet($request);
    }

    public function delete(Request $request)
    {
        try {
            return $this->deleteTimesheet($request);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Failed',
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the timesheet',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function getAllTimesheets()
    {
        $timesheets = Timesheet::all();
        return response()->json($timesheets, Response::HTTP_OK);
    }

    private function createTimesheet(Request $request)
    {
        $validatedData = $request->validate([
            'task_name' => 'required|string|max:255',
            'date' => 'required|date',
            'hours' => 'required|integer|min:0',
            'user_id' => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id',
        ]);

        $timesheet = Timesheet::create($validatedData);
        return response()->json($timesheet, Response::HTTP_CREATED);
    }

    private function getTimesheetById(string $id)
    {
        $timesheet = Timesheet::findOrFail($id);
        return response()->json($timesheet, Response::HTTP_OK);
    }

    private function updateTimesheet(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id' => 'required|string|exists:timesheets,id',
                'task_name' => 'sometimes|string|max:255',
                'date' => 'sometimes|date',
                'hours' => 'sometimes|integer|min:0',
                'user_id' => 'sometimes|exists:users,id',
                'project_id' => 'sometimes|exists:projects,id',
            ]);

            $timesheet = Timesheet::findOrFail($validatedData['id']);
            $timesheet->update($validatedData);

            return response()->json($timesheet, Response::HTTP_OK);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Failed',
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the timesheet',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function deleteTimesheet(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id' => 'required|string|exists:timesheets,id',
            ]);

            $timesheet = Timesheet::findOrFail($validatedData['id']);
            $timesheet->delete();

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Failed',
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the timesheet',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
