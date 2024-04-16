<?php

namespace App\Http\Controllers\Api;

use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;

class ClientCarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date',
            ]);
        } catch (ValidationException $e) {
            // If validation fails, return a JSON response with the error messages
            return response()->json(['error' => $e->errors()], 422);
        }

        // If validation passes, continue processing the request
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Now you can use these variables to perform any necessary actions
        // For example, you can pass them to a model to retrieve data from the database

        // Once you've processed the data, you can return the response with the relevant data
        $cars = Car::where('status', '=', 'available')->paginate(9);
        return response()->json(['cars' => $cars, 'start_date' => $start_date, 'end_date' => $end_date]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $car = Car::findOrFail($id);
            return response()->json(['data' => $car], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Car not found'], Response::HTTP_NOT_FOUND);
        }
    }
}
