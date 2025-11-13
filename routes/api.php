<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\PreventDoubleBooking;
use Illuminate\Support\Facades\Route;

Route::group([], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [UserController::class, 'getUser']);

    //admin specific routes
    Route::group(['middleware' => 'roles:admin'], function(){
        Route::put('/bookings/{booking_id}/confirm', [BookingController::class, 'update']);
    });

    /*
     * admin,organizer routes
     * organizer can only manage their own events
     * */
    Route::group(['middleware' => 'roles:admin,organizer'], function(){
        Route::resource('/events', EventController::class);
        Route::resource('/tickets', TicketController::class);
        Route::post('/events/{event_id}/tickets', [TicketController::class, 'store']);
    });

    //common routes
    Route::group(['middleware' => 'roles:admin,organizer,customer'], function(){
        Route::get('/bookings', [BookingController::class, 'index']);
        Route::post('/tickets/{ticket_id}/bookings', [BookingController::class, 'store'])->middleware(PreventDoubleBooking::class);
        Route::put('/bookings/{booking_id}/cancel', [BookingController::class, 'cancel']);
        Route::post('/bookings/{booking_id}/payment', [PaymentController::class, 'makePayment']);
    });
});
