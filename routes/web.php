<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlightController;

Route::resource('flights', FlightController::class);

Route::get('/', function () {
    return redirect(route('flights.index'));
});
