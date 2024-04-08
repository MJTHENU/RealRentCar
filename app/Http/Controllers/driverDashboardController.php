<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Car;
use App\Models\Reservation;
use App\Models\Insurance;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class driverDashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $clients = User::where('role', 'client')->count();
        $admins = User::where('role', 'admin')->count();
        $drivers = User::where('role', 'driver')->count(); // Corrected variable name
        $users = User::all()->count(); // Corrected variable name
        $owners = User::where('role', 'owner')->count();
        $cars = Car::all();

        $reservations = Reservation::paginate(8);
        $insurances = Insurance::all();
        $avatars = User::all();
        return view('driver.driverDashboard', compact('clients', 'avatars', 'admins', 'drivers', 'owners', 'cars', 'reservations', 'insurances')); // Corrected variable names
    }

    public function index(Request $request)
    {
        $driverId = Auth::id();
       
        $clients = User::where('role', 'client')->count();
        $admins = User::where('role', 'admin')->count();
        $drivers = User::where('role', 'driver')->count();
        $users = User::all()->count(); 
        $owners = User::where('role', 'owner')->count();
       

        $reservations = Reservation::paginate(8);
        $insurances = Insurance::all();
        $avatars = User::all();
        return view('driver.dashboard', compact('clients','driverId', 'avatars', 'admins', 'drivers', 'owners', 'cars', 'reservations', 'insurances')); // Corrected variable names
    }


    public function profile(Request $request)
    {
        $clients = User::where('role', 'client')->count();
        $admins = User::where('role', 'admin')->count();
        $drivers = User::where('role', 'driver')->count(); // Corrected variable name
        $users = User::all()->count(); // Corrected variable name
        $owners = User::where('role', 'owner')->count();
        $cars = Car::all();

        $reservations = Reservation::paginate(8);
        $insurances = Insurance::all();
        $avatars = User::all();
        $user_id = Auth::user()->id;
        return view('driver.profile' , compact('clients', 'avatars', 'admins', 'drivers', 'owners', 'cars', 'reservations', 'insurances')); // Corrected variable names
    }

  
    public function addnewcar(Request $request)
    {
        $clients = User::where('role', 'client')->count();
        $admins = User::where('role', 'admin')->count();
        $drivers = User::where('role', 'driver')->count(); // Corrected variable name
        $users = User::all()->count(); // Corrected variable name
        $owners = User::where('role', 'owner')->count();
        $cars = Car::all();

        $reservations = Reservation::paginate(8);
        $insurances = Insurance::all();
        $avatars = User::all();
        $user_id = Auth::user()->id;
        return view('driver.addnewcar' , compact('clients', 'avatars', 'admins', 'drivers', 'owners', 'cars', 'reservations', 'insurances')); // Corrected variable names
    }

    public function trip(Reservation $reservation)
    {
        
        $driverId = Auth::id();
        $reservation = new Reservation();
        $reservation = Reservation::find($reservation->id);
    
        if ($reservation) {
            $reservation->status = 'Confirm';
            $reservation->driver_id = $driverId; 
            $reservation->save();
        } 
      $confirmedReservations = Reservation::where('driver_id', $driverId)->paginate(8);
      $clients = User::where('role', 'client')->count();
        $admins = User::where('role', 'admin')->count();
        $drivers = User::where('role', 'driver')->count(); 
        $users = User::all()->count();
        $owners = User::where('role', 'owner')->count();
        $cars = Car::all();
        $avatars = User::all();
        $insurances = Insurance::all();
    
        return view('driver.trip', compact('clients', 'avatars', 'admins', 'drivers', 'owners', 'cars', 'confirmedReservations', 'insurances'));
    }
    
    public function confirmStatus(Reservation $reservation)
    {
       
        $driverId = Auth::id();

        $reservation = Reservation::find($reservation->id);
    
        $reservation->status = 'Confirm';
    
        $reservation->driver_id = $driverId;
    
        // Save the changes
        $reservation->save();
    
        // Fetch only the reservations with status "Confirm"
        $confirmedReservations = Reservation::where('status', 'Confirm')->paginate(8);
    
        // Fetch other necessary data
        $clients = User::where('role', 'client')->count();
        $admins = User::where('role', 'admin')->count();
        $drivers = User::where('role', 'driver')->count(); // Corrected variable name
        $users = User::all()->count(); // Corrected variable name
        $owners = User::where('role', 'owner')->count();
        $cars = Car::all();
        $avatars = User::all();
        $insurances = Insurance::all();
    
        // Redirect to the orderconfirm page
        return view('driver.trip', compact('clients', 'avatars', 'admins', 'drivers', 'owners', 'cars', 'confirmedReservations', 'insurances'));
    }

  

    
    public function editStatus(Reservation $reservation)
    {
        $reservation = Reservation::find($reservation->id);
        return view('driver.updateStatus', compact('reservation'));
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
        return redirect()->route('driver.trip');
    }

    public function editPayment(Reservation $reservation)
    {
        $reservation = Reservation::find($reservation->id);
        return view('driver.updatePayment', compact('reservation'));
    }

    public function updatePayment(Reservation $reservation, Request $request)
    {
        $reservation = Reservation::find($reservation->id);
        $reservation->payment_status = $request->payment_status;
        $reservation->save();
        return redirect()->route('driver.trip');
    }
}


