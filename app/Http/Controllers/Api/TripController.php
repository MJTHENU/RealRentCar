<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\Trip;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trips = Trip::all();
        return response()->json(['data' => $trips]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Define custom error messages
        $messages = [
            'required' => 'The :attribute field is required.',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|string',
            'booking_id' => 'required|string',
            'driver_id' => 'required|string',
            'start_loc' => 'nullable|string',
            'end_loc' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_hr' => 'nullable|date_format:H:i:s',
            'end_hr' => 'nullable|date_format:H:i:s',
            'start_km' => 'nullable|string',
            'end_km' => 'nullable|string',
            'extra_km' => 'nullable|string',
            'extra_charge' => 'nullable|string',
            'min_charge' => 'nullable|string',
            'waiting_charge' => 'nullable|string',
            'toll_charge' => 'nullable|string',
            'other_charges' => 'nullable|string',
            'total_amount' => 'nullable|string',
            'payment_status' => ['nullable', Rule::in(['pending', 'paid', 'failed'])],
            'status' => ['nullable', Rule::in(['process', 'start', 'complete', 'cancelled', 'partially completed'])],
        ], $messages);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], Response::HTTP_BAD_REQUEST);
        }

        // Create the trip
        $trip = Trip::create($request->all());

        return response()->json(['message' => 'Trip created successfully', 'data' => $trip], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $trip = Trip::findOrFail($id);
            return response()->json(['data' => $trip]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Trip not found'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Define custom error messages
        $messages = [
            'required' => 'The :attribute field is required.',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'user_id' => 'string',
            'booking_id' => 'string',
            'driver_id' => 'string',
            'start_loc' => 'nullable|string',
            'end_loc' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_hr' => 'nullable|date_format:H:i:s',
            'end_hr' => 'nullable|date_format:H:i:s',
            'start_km' => 'nullable|string',
            'end_km' => 'nullable|string',
            'extra_km' => 'nullable|string',
            'extra_charge' => 'nullable|string',
            'min_charge' => 'nullable|string',
            'waiting_charge' => 'nullable|string',
            'toll_charge' => 'nullable|string',
            'other_charges' => 'nullable|string',
            'total_amount' => 'nullable|string',
            'payment_status' => ['nullable', Rule::in(['pending', 'paid', 'failed'])],
            'status' => ['nullable', Rule::in(['process', 'start', 'complete', 'cancelled', 'partially completed'])],
        ], $messages);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], Response::HTTP_BAD_REQUEST);
        }

        // Find the trip
        $trip = Trip::findOrFail($id);

        // Update the trip
        $trip->update($request->all());

        return response()->json(['message' => 'Trip updated successfully', 'data' => $trip]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $trip = Trip::findOrFail($id);
            $trip->delete();
            return response()->json(['message' => 'Trip deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Trip not found'], Response::HTTP_NOT_FOUND);
        }
    }
}
