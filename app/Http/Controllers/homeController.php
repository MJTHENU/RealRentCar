<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class homeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $start = Carbon::parse($request->start_date); // Ensure $request is injected and available
    $end = Carbon::parse($request->end_date);
    return view('home', compact('start', 'end')); // Ensure $start is passed to the view
}
    /**
     * Show the form for creating a new resource.
     */
    
     public function show(Request $request)
     {  
         $startDate = $request->input('start_date');
         $endDate = $request->input('end_date');
     
         // Your logic to retrieve available cars based on the start date and end date
         $car = Car::find($request->input('car')); // Assuming you want to find a specific car based on the provided car_id
     
         return view('cars.cars', ['startDate' => $startDate, 'endDate' => $endDate, 'car' => $car]);
     }
     
    
    public function create($car_id)
    {
        $user = auth()->user();
        $car = Car::find($car_id);
        return view('home', compact('car', 'user'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $car_id)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',

        ]);


        $car = Car::find($car_id);
        $user = User::find($request->user);

        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);

        $reservation = new Reservation();
        $reservation->user()->associate($user);
        $reservation->car()->associate($car);
        $reservation->start_date = $start;
        $reservation->end_date = $end;
        $reservation->days = $start->diffInDays($end);
        $reservation->price_per_day = $car->price_per_day;
        $reservation->total_price = $reservation->days * $reservation->price_per_day;
        $reservation->status = 'Pending';
        $reservation->payment_method = 'At store';
        $reservation->payment_status = 'Pending';
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        //
    }
}