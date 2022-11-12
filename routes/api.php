<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AppointmentController;
use App\Http\Controllers\API\UserController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
   
Route::middleware('auth:api')->group( function () {
    Route::get('/auth/me', function(){
        $user = Auth::user();
        $userData = User::find(Auth()->user()->id);
        return response()->json($userData,200);
    });

    // Appointment
    Route::resource('/appointments', AppointmentController::class);
    Route::put('/cancel-appointment/{id}', [AppointmentController::class, 'cancel']);
});

Route::middleware('auth:api')->group( function () {
    Route::put('/admin/verify-appointment/{id}', [AppointmentController::class, 'confirmOrCancel'])->middleware(['admin']);

    // Users
    Route::get('/admin/users', [UserController::class, 'index'])->middleware(['admin']);
});