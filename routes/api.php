<?php

use App\Http\Controllers\Api\AppointmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\AvailabilityController;
use App\Http\Controllers\Api\BookingController;

Route::group(['prefix' => 'v1'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::middleware(['auth:api', 'throttle:api'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::middleware('host')->group(function () {
            Route::post('/availability', [AvailabilityController::class, 'create']);
            Route::get('/availability/{host_id}', [AvailabilityController::class, 'hostAvailavility']);

            Route::get('/appointments', [AppointmentController::class, 'list']);
            Route::put('/appointments/status', [AppointmentController::class, 'updateStatus']);

            Route::post('/booking-links', [BookingController::class, 'create']);
        });

        Route::middleware('guest')->group(function () {
            Route::post('/appointments', [AppointmentController::class, 'create']);
            Route::get('/booking-links/{slug}', [BookingController::class, 'getBookingLink']);
        });
    });
});
