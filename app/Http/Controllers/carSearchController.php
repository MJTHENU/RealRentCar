<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\car;

class carSearchController extends Controller
{
    public function search(Request $request)
    {
        // Parse prices to int
        // $minPrice = intval($request->min_price);
        // $maxPrice = intval($request->max_price);

        // Prepare the base query to select cars
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

<<<<<<< HEAD
        $featuresAC = [];
        if ($enquiry->AC === 'no') {
            $featuresAC[] = 'nonac';
        } else {
            $featuresAC[] =  $enquiry->AC;
        }
        
        $combinedacseat = $enquiry->seat.'seat' . implode('', $featuresAC);
        

        return view('cars.searchedCars', compact('cars','enquiry','combinedacseat'));
=======
        return view('cars.searchedCars', compact('cars','enquiry'));
>>>>>>> faebc6c74e55b14f682972a7772e1e51aae44f8c
    }
}
