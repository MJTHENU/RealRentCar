<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        // Validate the request data
        $validator = $this->validator($request->all());

        // If validation fails, return a validation error response
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Create a new user
        $user = $this->create($request->all());

        // Handle avatar upload
        if ($request->hasFile('avatar_choose') && $request->file('avatar_choose')->isValid()) {
            $avatarName = $request->name . '-' . Str::random(10) . '.' . $request->file('avatar_choose')->extension();
            $avatarNameNospaces = preg_replace('/\s+/', '', $avatarName);
            $path = $request->file('avatar_choose')->storeAs('/images/avatars', $avatarNameNospaces);
            $user->avatar = '/' . $path;
            $user->save();
        } else {
            $user->avatar = $request->avatar_option;
            $user->save();
        }

        // Trigger registered event
        event(new Registered($user));

        // Return a success response
        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'address1' => ['nullable', 'string', 'max:255'], 
            'address2' => ['nullable', 'string', 'max:255'], 
            'city' => ['nullable', 'string', 'max:255'], 
            'pincode' => ['nullable', 'string', 'max:255'], 
            'mobile_no' => ['nullable', 'string', 'max:255'], 
            'alternate_no' => ['nullable', 'string', 'max:255'], 
            'age' => ['nullable', 'string', 'max:255'], 
            'gender' => ['nullable', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'status' => ['nullable', 'string', 'max:255'],
            'reservation_id' => ['nullable', 'string', 'max:255'], 
            'insurance_number' => ['nullable', 'string', 'max:255', Rule::requiredIf(isset($data['role']) && $data['role'] === 'owner')],
            'license_number' => ['nullable', 'string', 'max:255', Rule::requiredIf(isset($data['role']) && $data['role'] === 'driver')],

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'insurance_number' => $data['insurance_number'] ?? null,
            'license_number' => $data['license_number'] ?? null,
            'password' => Hash::make($data['password']),
            // Add other common fields here as needed
        ]);
    }
}

