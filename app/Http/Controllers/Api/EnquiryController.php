<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EnquiryController extends Controller
{
    /**
     * Display a listing of the enquiries.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $enquiries = Enquiry::all();
        return response()->json(['data' => $enquiries]);
    }

    /**
     * Store a newly created enquiry in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'mobile_no' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'start_loc' => 'required',
            'end_loc' => 'required',
            'seat' => 'required',
            'luggage' => 'required',
            'vehicle_type' => 'required',
            'AC' => 'required',
            'desc' => 'required',
            'journey_type' => ['required', Rule::in(['drop', 'drop&pickup'])],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $enquiry = Enquiry::create($request->all());

        return response()->json(['message' => 'Enquiry added successfully', 'data' => $enquiry], 201);
    }

    /**
     * Display the specified enquiry.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $enquiry = Enquiry::findOrFail($id);
        return response()->json(['data' => $enquiry]);
    }

    /**
     * Update the specified enquiry in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $enquiry = Enquiry::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'mobile_no' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'start_loc' => 'required',
            'end_loc' => 'required',
            'seat' => 'required',
            'luggage' => 'required',
            'vehicle_type' => 'required',
            'AC' => 'required',
            'desc' => 'required',
            'journey_type' => ['required', Rule::in(['drop', 'drop&pickup'])],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $enquiry->update($request->all());

        return response()->json(['message' => 'Enquiry updated successfully', 'data' => $enquiry]);
    }

    /**
     * Remove the specified enquiry from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $enquiry = Enquiry::findOrFail($id);
        $enquiry->delete();
        return response()->json(['message' => 'Enquiry deleted successfully']);
    }
}
