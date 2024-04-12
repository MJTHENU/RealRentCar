<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Car::paginate(8);
        return response()->json(['message' => 'Cars retrieved successfully', 'data' => $cars], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_id' => 'required',
            'vehicle_id' => 'required',
            'brand' => 'required',
            'model' => 'required',
            'engine' => 'required',
            'seat' => 'required',
            'luggage' => 'required',
            'ac' => 'required',
            'approval' => 'required',
            'vehicle_type' => 'required',
            'price_per_km' => 'required',
            'price_per_hr' => 'required',
            'price_per_day' => 'required',
            'quantity' => 'required',
            'insurance_status' => 'required',
            'status' => 'required',
            'reduce' => 'required',
            'stars' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Adjust the max file size as needed
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $car = Car::create($validator->validated());

        return response()->json(['message' => 'Car added successfully', 'data' => $car], 201);
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $car = Car::find($id);
        if (!$car) {
            return response()->json(['message' => 'Car not found'], 404);
        }
        return response()->json(['message' => 'Car retrieved successfully', 'data' => $car], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'email_id' => 'required',
            'vehicle_id' => 'required',
            'brand' => 'required',
            'model' => 'required',
            'engine' => 'required',
            'seat' => 'required',
            'luggage' => 'required',
            'ac' => 'required',
            'approval' => 'required',
            'vehicle_type' => 'required',
            'price_per_km' => 'required',
            'price_per_hr' => 'required',
            'price_per_day' => 'required',
            'quantity' => 'required',
            'insurance_status' => 'required',
            'status' => 'required',
            'reduce' => 'required',
            'stars' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Adjust the max file size as needed
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $car = Car::find($id);
        if (!$car) {
            return response()->json(['message' => 'Car not found'], 404);
        }

        $car->update($validator->validated());

        return response()->json(['message' => 'Car updated successfully', 'data' => $car], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $car = Car::find($id);
        if (!$car) {
            return response()->json(['message' => 'Car not found'], 404);
        }
        $car->delete();
        return response()->json(['message' => 'Car deleted successfully'], 204);
    }

}
