<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CarSearchApiController extends Controller
{
    public function search(Request $request)
    {
        try {
            $request->validate([
                'vehicle_type' => 'required|string',
                'seat' => 'required|string',
                'ac' => ['required', Rule::in(['yes', 'no'])],
                'luggage' => 'required|string',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $query = Car::query();

        if ($request->filled('vehicle_type')) {
            $query->where('vehicle_type', 'like', '%' . $request->vehicle_type . '%');
        }

        if ($request->filled('seat')) {
            $query->where('seat', 'like', '%' . $request->seat . '%');
        }

        if ($request->filled('ac')) {
            $query->where('ac', $request->ac);
        }

        if ($request->filled('luggage')) {
            $query->where('luggage', 'like', '%' . $request->luggage . '%');
        }

        $query->where('status', '=', 'available');

        $cars = $query->paginate(9);

        return response()->json($cars);
    }
}
