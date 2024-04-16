<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use App\Models\Tariff;

class TariffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tariffs = Tariff::all();
        return response()->json(['data' => $tariffs], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate($this->getValidationRules($request));
        } catch (ValidationException $e) {
            if ($e->validator->fails()) {
                $errors = $e->validator->errors()->all();
                return response()->json(['error' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        $tariff = Tariff::create($validatedData);

        return response()->json(['message' => 'Tariff created successfully', 'data' => $tariff], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tariff = Tariff::findOrFail($id);
        return response()->json(['data' => $tariff], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validatedData = $request->validate($this->getValidationRules($request));
        } catch (ValidationException $e) {
            if ($e->validator->fails()) {
                $errors = $e->validator->errors()->all();
                return response()->json(['error' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        $tariff = Tariff::findOrFail($id);
        $tariff->update($validatedData);

        return response()->json(['message' => 'Tariff updated successfully', 'data' => $tariff], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tariff = Tariff::findOrFail($id);
        $tariff->delete();
        return response()->json(['message' => 'Tariff deleted successfully'], Response::HTTP_OK);
    }

    /**
     * Get the validation rules.
     */
    protected function getValidationRules(Request $request)
    {
        return [
            'plan_name' => 'required|string',
            'tariff_type' => 'required|in:per_km,per_hr,per_day',
            'price_per_km' => $request->tariff_type == 'per_km' ? 'required|numeric' : 'nullable|numeric',
            'price_per_hr' => $request->tariff_type == 'per_hr' ? 'required|numeric' : 'nullable|numeric',
            'price_per_day' => $request->tariff_type == 'per_day' ? 'required|numeric' : 'nullable|numeric',
            'max_km' => 'nullable|numeric',
            'min_charge' => 'nullable|numeric',
            'extra_km' => 'nullable|numeric',
            'waiting_charge' => 'nullable|numeric',
            'car_brand' => 'required|string',
            'car_model' => 'required|string',
            'vehicle_type' => 'required|string',
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ];
    }

}
