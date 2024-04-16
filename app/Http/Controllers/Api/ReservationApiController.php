<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class ReservationApiController extends Controller
{

    public function index(Request $request)
    {
        try {
            // Check if the request is authenticated
            if (!$request->user()) {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }

            // Get the authenticated user
            $user = $request->user();

            // Get all reservations visible to the user
            $reservations = Reservation::where('user_id', $user->id)->get();

            return response()->json(['data' => $reservations], 200);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error fetching reservations: ' . $e->getMessage());

            // Handle other exceptions
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function store(Request $request, $car_id)
    {
        try {
            // Validate the incoming request data
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'start_date' => 'required|date|after_or_equal:today',
                'end_date' => 'required|date|after:start_date',
                'plan' => 'required|in:per_km,per_hr,per_day',
                'start_km' => 'numeric|required_if:plan,per_km',
                'end_km' => 'numeric|gt:start_km|required_if:plan,per_km',
                'start_hour' => 'date_format:H:i|required_if:plan,per_hr',
                'end_hour' => 'date_format:H:i|after:start_hour|required_if:plan,per_hr',
            ]);

            // Find the car and user
            $car = Car::findOrFail($car_id);
            $user = User::findOrFail($request->user_id);

            // Process reservation data
            $start = Carbon::parse($request->start_date);
            $end = Carbon::parse($request->end_date);
            $start_hour = Carbon::parse($request->start_hour);
            $end_hour = Carbon::parse($request->end_hour);
            $end_km = $request->end_km;
            $start_km = $request->start_km;

            // Create a new reservation
            $reservation = new Reservation();
            $reservation->user()->associate($user);
            $reservation->car()->associate($car);
            $reservation->start_date = $start;
            $reservation->end_date = $end;
            $reservation->plan_type = $request->plan;
            $reservation->start_km = $start_km;
            $reservation->end_km = $end_km;
            $reservation->start_hr = $start_hour;
            $reservation->end_hr = $end_hour;
            $reservation->days = $start->diffInDays($end);
            $reservation->hours = $start_hour->diffInHours($end_hour);
            $reservation->kilometer = $end_km - $start_km;

            // Calculate total price based on plan
            switch ($request->plan) {
                case 'per_day':
                    $reservation->price_per_day = $car->price_per_day;
                    $reservation->total_price = $reservation->kilometer * $reservation->price_per_day;
                    break;
                case 'per_hr':
                    $reservation->price_per_hr = $car->price_per_hr;
                    $reservation->total_price = $reservation->hours * $reservation->price_per_hr;
                    break;
                case 'per_km':
                    $reservation->price_per_km = $car->price_per_km;
                    $reservation->total_price = $reservation->price_per_km * $reservation->kilometer;
                    break;
            }

            // Set reservation status and payment method
            $reservation->status = 'Pending';
            $reservation->payment_method = 'Cash';
            $reservation->payment_status = 'Pending';

            // Save the reservation
            $reservation->save();

            // Update car status to Reserved
            $car->status = 'Reserved';
            $car->save();

            // Return a JSON response with the reservation data
            return response()->json(['message' => 'Reservation created successfully', 'data' => $reservation], 201);
        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $reservation = Reservation::findOrFail($id);
            return response()->json(['data' => $reservation], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Reservation not found'], 404);
        }
    }


    /**
 * Update the specified reservation in storage.
 */
    public function update(Request $request, $id)
    {
        //
        try {
            // Find the reservation by its ID
            $reservation = Reservation::findOrFail($id);

            // Validate the incoming request data
            $request->validate([
                'user_id' => 'exists:users,id',
                'start_date' => 'date|after_or_equal:today',
                'end_date' => 'date|after:start_date',
                'plan' => 'in:per_km,per_hr,per_day',
                'start_km' => 'numeric|required_if:plan,per_km',
                'end_km' => 'numeric|gt:start_km|required_if:plan,per_km',
                'start_hour' => 'date_format:H:i|required_if:plan,per_hr',
                'end_hour' => 'date_format:H:i|after:start_hour|required_if:plan,per_hr',
            ]);

            // Update the reservation data with the incoming request data
            $reservation->user_id = $request->user_id;
            $reservation->start_date = $request->start_date;
            $reservation->end_date = $request->end_date;
            $reservation->plan_type = $request->plan;
            $reservation->start_km = $request->start_km;
            $reservation->end_km = $request->end_km;
            $reservation->start_hr = $request->start_hour;
            $reservation->end_hr = $request->end_hour;

            // Save the updated reservation
            $reservation->save();

            // Return a JSON response with the updated reservation data
            return response()->json(['message' => 'Reservation updated successfully', 'data' => $reservation], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Reservation not found'], 404);
        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error updating reservation: ' . $e->getMessage());

            // Handle other exceptions
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
 * plan chanage not working .
 */
    public function update1(Request $request, $id)
    {
        try {
            // Find the reservation by its ID
            $reservation = Reservation::findOrFail($id);

            // Validate the incoming request data
            $request->validate([
                'user_id' => 'exists:users,id',
                'start_date' => 'required|date|after_or_equal:today',
                'end_date' => 'required|date|after:start_date',
                'plan' => 'required|in:per_km,per_hr,per_day',
                'start_km' => 'numeric|required_if:plan,per_km',
                'end_km' => 'numeric|gt:start_km|required_if:plan,per_km',
                'start_hour' => 'required_if:plan,per_hr|date_format:H:i',
                'end_hour' => 'required_if:plan,per_hr|date_format:H:i|after:start_hour',
            ]);

            // Update the reservation data with the incoming request data
            $reservation->fill($request->all());

            // Calculate derived attributes
            if ($request->plan === 'per_km') {
                $reservation->kilometer = $request->end_km - $request->start_km;
            }

            if ($request->plan === 'per_hr') {
                $start_hour = Carbon::parse($request->start_hour);
                $end_hour = Carbon::parse($request->end_hour);
                $reservation->hours = $start_hour->diffInHours($end_hour);
            }

            // Update price and total_price based on plan
            switch ($request->plan) {
                case 'per_day':
                    $reservation->price_per_day = $reservation->car->price_per_day;
                    $reservation->total_price = $reservation->days * $reservation->price_per_day;
                    break;
                case 'per_hr':
                    $reservation->price_per_hr = $reservation->car->price_per_hr;
                    $reservation->total_price = $reservation->hours * $reservation->price_per_hr;
                    break;
                case 'per_km':
                    $reservation->price_per_km = $reservation->car->price_per_km;
                    $reservation->total_price = $reservation->kilometer * $reservation->price_per_km;
                    break;
            }

            $reservation->status = 'Pending';
            $reservation->payment_method = 'Cash';
            $reservation->payment_status = 'Pending';

            $reservation->save();

            // Return a JSON response with the updated reservation data
            return response()->json(['message' => 'Reservation updated successfully', 'data' => $reservation], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Reservation not found'], 404);
        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $reservation = Reservation::findOrFail($id);
            $reservation->delete();
            return response()->json(['message' => 'Reservation deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Reservation not found'], 404);
        }
    }

}
