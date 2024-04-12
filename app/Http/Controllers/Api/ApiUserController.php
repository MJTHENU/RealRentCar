<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiUserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json(['message' => 'Users retrieved successfully', 'data' => $users], 200);
    }

    public function store(Request $request)
    {
        // Define validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required', // Ensure password is required
            // Add validation rules for other fields
        ];

        // Define custom validation messages
        $messages = [
            'required' => 'The :attribute field is required.',
            'email' => 'The :attribute must be a valid email address.',
            'unique' => 'The :attribute has already been taken.',
            // Add more custom messages for other validation rules as needed
        ];

        // Validate the incoming request data
        $validator = Validator::make($request->all(), $rules, $messages);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Create a new user with the validated data
        $user = User::create($request->all());

        // Return the newly created user along with 201 status code
        return response()->json(['message' => 'User added successfully', 'data' => $user], 201);
    }

    public function show(User $user)
    {
        return response()->json(['message' => 'User retrieved successfully', 'data' => $user], 200);
    }

    // public function update(Request $request, User $user)
    // {
    //     $user->update($request->all());
    //     return response()->json(['message' => 'User updated successfully', 'data' => $user], 200);
    // }

    public function update(Request $request, User $user)
    {
        // Define validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|string|in:admin,driver,owner',
            // Add validation rules for other fields
        ];

        // Apply conditional validation rules based on the role field
        if ($request->has('role')) {
            $data = $request->all();
            if ($data['role'] === 'owner') {
                $rules['insurance_number'] = ['nullable', 'string', 'max:255', 'required_if:role,owner'];
                unset($data['license_number']); // Unset license_number field
            } elseif ($data['role'] === 'driver') {
                $rules['license_number'] = ['nullable', 'string', 'max:255', 'required_if:role,driver'];
                unset($data['insurance_number']); // Unset insurance_number field
            }
            $request->merge($data); // Merge modified data back into request
        }

        // Define custom validation messages
        $messages = [
            'required' => 'The :attribute field is required.',
            'email' => 'The :attribute must be a valid email address.',
            'unique' => 'The :attribute has already been taken.',
            // Add more custom messages for other validation rules as needed
        ];

        // Validate the incoming request data
        $validator = Validator::make($request->all(), $rules, $messages);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Update the user with the validated data
        $user->update($validator->validated());

        // Return the updated user along with a success message
        return response()->json(['message' => 'User updated successfully', 'data' => $user], 200);
    }



    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 204);
    }
}
