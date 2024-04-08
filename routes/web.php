<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CarController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\clientCarController;
use App\Http\Controllers\adminDashboardController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\usersController;
use App\Http\Controllers\addNewAdminController;
use App\Http\Controllers\invoiceController;
use App\Http\Controllers\AdminAuth\LoginController;
use App\Http\Controllers\carSearchController;
use App\Http\Controllers\driverDashboardController;
use App\Http\Controllers\ownerDashboardController;
use App\Models\User;
use App\Models\Enquiry;
use App\Models\Car;
use App\Models\Reservation;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\homeController;


// ------------------- guest routes --------------------------------------- //
Route::get('/', [homeController::class, 'index'])->name('home');
Route::post('/enquiry', 'App\Http\Controllers\homeController@submitReservation')->name('enquiry_details');




Route::get('/', function () {
    $cars = Car::take(6)->where('status', '=', 'available')->get();
    return view('home', compact('cars'));
})->name('home');

Route::get('/viewenquiry', [EnquiryController::class, 'index'])->name('enquiry');
Route::get('/storeenquiry', [EnquiryController::class, 'store'])->name('store_enquiry');

Route::get('/cars', [clientCarController::class, 'index'])->name('cars');
Route::get('/cars/search', [carSearchController::class, 'search'])->name('carSearch');

Route::get('location', function () {
    return view('location');
})->name('location');

Route::get('contact_us', function () {
    return view('contact_us');
})->name('contact_us');

Route::get('admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [LoginController::class, 'login'])->name('admin.login.submit');

Route::redirect('/admin', 'admin/login');

Route::get('/privacy_policy',
function () {
    return view('Privacy_Policy');
})->name('privacy_policy');

Route::get('/terms_conditions',
function () {
    return view('Terms_Conditions');
})->name('terms_conditions');



// -------------------------------------------------------------------------//




// ------------------- admin routes --------------------------------------- //





Route::prefix('driver')->middleware(['auth', \App\Http\Middleware\driverMiddleware::class])->group(function () {
    Route::get('/dashboard', driverDashboardController::class,'index')->name('driver.dashboard');
});

Route::prefix('driver')->middleware(['auth', \App\Http\Middleware\driverMiddleware::class])->group(function () {
    Route::get('/profile', [driverDashboardController::class, 'profile'])->name('driver.profile');
});

Route::prefix('driver')->middleware(['auth', \App\Http\Middleware\driverMiddleware::class])->group(function () {
    Route::get('/trip', [driverDashboardController::class, 'trip'])->name('driver.trip');
});

Route::prefix('driver')->middleware(['auth', \App\Http\Middleware\driverMiddleware::class])->group(function () {
    Route::get('/addnewcar', [driverDashboardController::class, 'addnewcar'])->name('driver.addnewcar');
   
});

Route::prefix('driver')->middleware(['auth', \App\Http\Middleware\driverMiddleware::class])->group(function () {
Route::get('/orderconfirm/{reservation}', [driverDashboardController::class, 'confirmStatus'])->name('confirmstatus');
//Route::put('/updateReservation/{reservation}', [driverDashboardController::class, 'updateStatus'])->name('updateStatus');
});

Route::prefix('driver')->middleware(['auth', \App\Http\Middleware\driverMiddleware::class])->group(function () {
Route::get('/tripreserve/{reservation}', [driverDashboardController::class, 'editStatus'])->name('tripreserve');
Route::put('/updatereserve/{reservation}', [driverDashboardController::class, 'updateStatus'])->name('tripstatus');
Route::get('/editpayment/{reservation}', [driverDashboardController::class, 'editPayment'])->name('editpayment');
Route::put('/updatepayment/{reservation}', [driverDashboardController::class, 'updatePayment'])->name('updatepayment');
});

Route::prefix('owner')->middleware(['auth', \App\Http\Middleware\ownerMiddleware::class])->group(function () {
    Route::get('/dashboard', ownerDashboardController::class)->name('owner.ownerDashboard');
});
Route::prefix('owner')->middleware(['auth', \App\Http\Middleware\ownerMiddleware::class])->group(function () {
    Route::get('/profile', [ownerDashboardController::class, 'profile'])->name('owner.profile');
});
Route::prefix('owner')->middleware(['auth', \App\Http\Middleware\ownerMiddleware::class])->group(function () {
    Route::get('/addnewcar', [ownerDashboardController::class, 'cars'])->name('owner.cars');
});


Route::prefix('admin')->middleware('admin')->group(function () {

    Route::get(
        '/dashboard',
        adminDashboardController::class
    )->name('adminDashboard');

  

    Route::resource('cars', CarController::class);

    // Route::resource('reservations', ReservationController::class);

    Route::resource('insurances', InsuranceController::class);

    Route::get('/users', function () {

        $admins = User::where('role', 'admin')->get();
        $owners = User::where('role', 'owner')->get();
        $drivers = User::where('role', 'driver')->get(); 
        $users = User::where('role', 'user')->get();// 
        $clients = User::where('role', 'client')->paginate(5);

        return view('admin.users', compact('admins', 'clients','owners','drivers','users'));
    })->name('users');

    Route::get('/updatePayment/{reservation}', [ReservationController::class, 'editPayment'])->name('editPayment');
    Route::put('/updatePayment/{reservation}', [ReservationController::class, 'updatePayment'])->name('updatePayment');

    Route::get('/updateReservation/{reservation}', [ReservationController::class, 'editStatus'])->name('editStatus');
    Route::put('/updateReservation/{reservation}', [ReservationController::class, 'updateStatus'])->name('updateStatus');

    Route::get('/addAdmin', [usersController::class, 'create'])->name('addAdmin');
    Route::post('/addAdmin', [addNewAdminController::class, 'register'])->name('addNewAdmin');

    // Route::delete('/deleteUser/{user}', [usersController::class, 'destroy'])->name('deleteUser');

    Route::get('/userDetails/{user}', [usersController::class, 'show'])->name('userDetails');
});

// --------------------------------------------------------------------------//




// ------------------- client routes --------------------------------------- //
//Route::get('/reservations', [ReservationController::class, 'show'])->name('car.reservation');
Route::get('/reservations/{car}', [ReservationController::class, 'create'])->name('car.reservation')->middleware('auth', 'restrictAdminAccess');
Route::post('/reservations/{car}', [ReservationController::class, 'store'])->name('car.reservationStore')->middleware('auth', 'restrictAdminAccess');

Route::get('/reservations', function () {

    $reservations = Reservation::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
    return view('clientReservations', compact('reservations'));
})->name('clientReservation')->middleware('auth', 'restrictAdminAccess');


route::get('invoice/{reservation}', [invoiceController::class, 'invoice'])->name('invoice')->middleware('auth', 'restrictAdminAccess');


//---------------------------------------------------------------------------//



Route::get('/test', function () {
    return view('test');
})->name('test');



Auth::routes();
