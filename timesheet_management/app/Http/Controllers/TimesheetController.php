<?php

namespace App\Http\Controllers;

use App\Models\Timesheet;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TimesheetController extends Controller
{
    public function index()
    {
        $timesheets = Timesheet::all();
        return response()->json($timesheets, Response::HTTP_OK);
    }

    public function store(Request $request)
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

    public function show(string $id)
    {
        $timesheet = Timesheet::findOrFail($id);
        return response()->json($timesheet, Response::HTTP_OK);
    }

    public function update(Request $request, string $id)
    {
        $timesheet = Timesheet::findOrFail($id);

        $validatedData = $request->validate([
            'task_name' => 'string|max:255',
            'date' => 'date',
            'hours' => 'integer|min:0',
            'user_id' => 'exists:users,id',
            'project_id' => 'exists:projects,id',
        ]);

        $timesheet->update($validatedData);
        return response()->json($timesheet, Response::HTTP_OK);
    }

    public function destroy(string $id)
    {
        $timesheet = Timesheet::findOrFail($id);
        $timesheet->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
