<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enquiry;
use App\Models\Car;

class EnquiryController extends Controller
{
    public function index()
    {
        // $enquiry = Enquiry::all();
        return view('enquiry');
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'mobile_no' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'start_loc' => 'required',
            'end_loc' => 'required',
            'seat' => 'required',
            'luckage' => 'required',
            'vehicle_type' => 'required',
            'AC' => 'required|in:yes,no',
            'desc' => 'required',
            'journey_type' => 'required',
        ]);

        // Create a new Enquiry instance and assign fields using mass assignment
        $enquiry = new Enquiry();
        $enquiry->name= $request->name;
        $enquiry->email = $request->email;
        $enquiry->address = $request->address;
        $enquiry->mobile_no = $request->mobile_no;
        $enquiry->start_loc = $request->start_loc;
        $enquiry->end_loc = $request->end_loc;
        $enquiry->desc = $request->desc;
        $enquiry->start_date = $request->start_date;
        $enquiry->end_date = $request->end_date;
        $enquiry->seat = $request->seat;
        $enquiry->luggage = $request->luckage;
        $enquiry->vehicle_type = $request->vehicle_type;
        $enquiry->AC = $request->AC;
        $enquiry->save();

        //$cars = Car::all();
       // return view('cars.searchedCars', compact('cars','enquiry'));
       $query = Car::query();

       // Check if the 'brand' input is provided and add the filter to the query
       if ($request->filled('vehicle_type')) {
           $query->where('vehicle_type', 'like', '%' . $request->vehicle_type . '%');
       }

       // Check if the 'model' input is provided and add the filter to the query
       if ($request->filled('seat')) {
           $query->where('seat', 'like', '%' . $request->seat . '%');
       }

       if ($request->filled('ac')) {
           $query->where('ac', 'like', '%' . $request->ac . '%');
       }

       if ($request->filled('luggage')) {
           $query->where('luggage', 'like', '%' . $request->luggage . '%');
       }

       // Add the 'status' filter to only show available cars
       $query->where('status', '=', 'available');

       // Execute the query and paginate the results
       $cars = $query->paginate(9);

       // Include any additional query parameters in the pagination links
       $cars->appends($request->except('page'));



       
   


      return view('cars.searchedCars', compact('cars','enquiry'));
      // return view('reservation.create', compact('cars', 'enquiry'));

    }
}
