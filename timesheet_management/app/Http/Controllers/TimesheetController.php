<?php

namespace App\Http\Controllers;

use App\Models\Timesheet;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TimesheetController extends Controller
{
    public function index()
    {
        return $this->getAllTimesheets();
    }

    public function store(Request $request)
    {
        return $this->createTimesheet($request);
    }

    public function show(string $id)
    {
        return $this->getTimesheetById($id);
    }

    public function update(Request $request)
    {
        return $this->updateTimesheet($request);
    }

    public function delete(Request $request)
    {
        return $this->deleteTimesheet($request);
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
    }

    private function deleteTimesheet(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|string|exists:timesheets,id',
        ]);

        $timesheet = Timesheet::findOrFail($validatedData['id']);
        $timesheet->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
