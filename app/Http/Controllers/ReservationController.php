<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tariff;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($car_id)
    {
        $user = auth()->user();
        $car = Car::find($car_id);
        
        // Retrieve data from query parameters
        $enquiry = (object) [
            'name' => request()->query('name'),
            'email' => request()->query('email'),
            'address' => request()->query('address'),
            'mobile_no' => request()->query('mobile_no'),
            'start_loc' => request()->query('start_loc'),
            'end_loc' => request()->query('end_loc'),
            'desc' => request()->query('desc'),
            'start_date' => request()->query('start_date'),
            'end_date' => request()->query('end_date'),
            'seat' => request()->query('seat'),
            'luggage' => request()->query('luckage'),
            'vehicle_type' => request()->query('vehicle_type'),
            'AC' => request()->query('AC')
        ];
    

        $featuresAC = [];
        if ($enquiry->AC === 'no') {
            $featuresAC[] = 'nonac';
        } else {
            $featuresAC[] =  $enquiry->AC;
        }
        
        $combinedacseat = $enquiry->seat.'seat' . implode('', $featuresAC);

        return view('reservation.create', compact('car', 'user', 'enquiry','combinedacseat'));
    }
    

    public function show(Reservation $reservation)
    {
       
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $car_id)
    {
        $rules = [];
if ($request->plan == 'per_day') {
    $rules = [
        'start_date' => 'required|date|after_or_equal:today',
        'end_date' => 'required|date|after:start_date',
    ];
} else if ($request->plan == 'per_hr') {
    $rules = [
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
    ];
} else if ($request->plan == 'per_km') {
    $rules = [
        'start_km' => 'required|numeric',
        'end_km' => 'required|numeric|gt:start_km', // Assuming end_km should be greater than start_km
    ];
}


        $car = Car::find($car_id);
        $user = User::find($request->user);

        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        $start_hour = Carbon::parse($request->start_hour);
        $end_hour = Carbon::parse($request->end_hour);
        $end_km = $request->end_km;
        $start_km = $request->start_km;

        $reservation = new Reservation();
        $reservation->user()->associate($user);
        $reservation->car()->associate($car);
        $reservation->start_date = $start;
        $reservation->end_date = $end;
        $reservation->days = $start->diffInDays($end);
        $reservation->hours = $start_hour->diffInHours($end_hour);
        $reservation->kilometer = $end_km - $start_km;

        if ($request->plan == 'per_day') {
            $reservation->price_per_day = $car->price_per_day;
            $reservation->total_price = $reservation->kilometer * $reservation->price_per_day;
        } else if ($request->plan == 'per_hr') {
            $reservation->price_per_hr = $car->price_per_hr; 
            $reservation->total_price = $reservation->hours * $reservation->price_per_hr; 
            
        $reservation->start_hr = $start_hour;
        $reservation->end_hr = $end_hour;
        } else if ($request->plan == 'per_km') {
            $reservation->price_per_km = $car->price_per_km; 
            $reservation->total_price = $reservation->price_per_km * $reservation->kilometer;
            
        $reservation->start_km = $start_km;
        $reservation->end_km = $end_km;
        }
        
        
        $reservation->status = 'Pending';
        $reservation->payment_method = 'Cash';
        $reservation->payment_status = 'Pending';
        
        $combinedacseat = $request->input('combinedacseat');

        $tariff = Tariff::where('plan_name', $combinedacseat)
    ->where('car_brand', $car->brand)
    ->where('car_model', $car->model)
    ->where('vehicle_type', $car->vehicle_type)
    ->first();
    if ($tariff) {
        $reservation->tariff_id = $tariff->id;
    }



        $reservation->save();


        
        $car->status = 'Reserved';
        $car->save();
        

 

        return view('thankyou',['reservation'=>$reservation] );
    }

    /**
     * Display the specified resource.
     */
  

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    // Edit and Update Payment status
    public function editPayment(Reservation $reservation)
    {
        $reservation = Reservation::find($reservation->id);
        return view('admin.updatePayment', compact('reservation'));
    }

    public function updatePayment(Reservation $reservation, Request $request)
    {
        $reservation = Reservation::find($reservation->id);
        $reservation->payment_status = $request->payment_status;
        $reservation->save();
        return redirect()->route('adminDashboard');
    }

    // Edit and Update Reservation Status
    public function editStatus(Reservation $reservation)
    {
        $reservation = Reservation::find($reservation->id);
        return view('admin.updateStatus', compact('reservation'));
    }

    public function updateStatus(Reservation $reservation, Request $request)
    {
        $reservation = Reservation::find($reservation->id);
        $reservation->status = $request->status;
        $car = $reservation->car;
        if($request->status == 'Ended' || $request->status == 'Canceled' ){
            $car->status = 'Available';
            $car->save();
        }
        $reservation->save();
        return redirect()->route('adminDashboard');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    
}