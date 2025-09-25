<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ApplicationController;

Route::get('/', function () {
    return view('welcome');
});

// Registration routes
Route::resource('registrations', RegistrationController::class);

// Application routes
Route::resource('applications', ApplicationController::class);

// Additional application routes
Route::put('applications/{application}/status', [ApplicationController::class, 'updateStatus'])->name('applications.status');
Route::put('applications/{application}/payment', [ApplicationController::class, 'updatePaymentStatus'])->name('applications.payment');
Route::post('registrations/{registration}/application', [ApplicationController::class, 'createFromRegistration'])->name('applications.fromRegistration');
