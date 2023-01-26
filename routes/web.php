<?php

use App\Http\Controllers\Auth\OTPController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/otp/login',[OTPController::class,'login'])->name('otp-login');
Route::post('/generate/otp',[OTPController::class,'otpGenerate'])->name('generate-otp');
Route::get('/otp/verification/{user_id}',[OTPController::class,'otpVerification'])->name('otp-verification');
Route::post('/otp/login',[OTPController::class,'otpLogin'])->name('verified-otp-login');


Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified'])->group(function () {
    Route::get('/dashboard',function () {return view('dashboard');})->name('dashboard')->middleware('checkOtp');
      
});

