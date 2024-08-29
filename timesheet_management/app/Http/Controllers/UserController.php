<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
    {
        return $this->getAllUsers();
    }

    public function store(Request $request)
    {
        return $this->createUser($request);
    }

    public function show(string $id)
    {
        return $this->getUserById($id);
    }

    public function update(Request $request)
    {
        return $this->updateUser($request);
    }

    public function delete(Request $request)
    {
        return $this->deleteUser($request);
    }

    private function getAllUsers()
    {
        $users = User::with(['projects', 'timesheets'])->get();
        return response()->json($users, Response::HTTP_OK);
    }

    private function createUser(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email|max:255',
                'password' => 'required|string|min:8',
                'gender' => 'required|string|max:10',
                'date_of_birth' => 'required|date',
            ]);

            $user = User::create($validatedData);
            return response()->json($user, Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Failed',
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    private function getUserById(string $id)
    {
        $user = User::with(['projects', 'timesheets'])->findOrFail($id);
        return response()->json($user, Response::HTTP_OK);
    }

    private function updateUser(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id' => 'required|string|exists:users,id',
                'first_name' => 'sometimes|string|max:255',
                'last_name' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|unique:users,email|max:255',
                'password' => 'sometimes|string|min:8',
                'gender' => 'sometimes|string|max:10',
                'date_of_birth' => 'sometimes|date',
            ]);

            $user = User::findOrFail($validatedData['id']);
            $user->update($validatedData);

            return response()->json($user, Response::HTTP_OK);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Failed',
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    private function deleteUser(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id' => 'required|string|exists:users,id',
            ]);

            $user = User::findOrFail($validatedData['id']);
            $user->delete();

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Failed',
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
