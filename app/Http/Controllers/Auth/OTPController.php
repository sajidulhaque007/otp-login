<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\UserOtp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OTPController extends Controller
{
    public function login(){
        return view('auth.otplogin');
    }

    public function otpGenerate(Request $request){

        $request->validate([
            'mobile_no' => 'required|exists:users,mobile_no|min:14'
        ]);
        $userOTP = $this->generateOTP($request->mobile_no);
        $userOTP->sendSms($request->mobile_no);
        return redirect(route('otp-verification',[$userOTP->user_id]))
            ->with('status','OTP sent successfully to your Mobile No!');
    }
    public function generateOTP($mobile_no){
        $user = User::where('mobile_no',$mobile_no)->first();
        $userOTP = UserOtp::where('user_id',$user->id)->latest()->first();
        $now = now();

        if($userOTP && $now->isBefore($userOTP->expire_at) ){
            return $userOTP;
        }

        return UserOtp::create([
            'user_id' => $user->id,
            'otp' => rand(12345,22222),
            'expire_at' => $now->addMinutes(5)
        ]);
    }

    public function otpVerification($user_id){
        return view('auth.otpVerification')->with([
            'user_id' => $user_id,
            
        ]);
    }
    public function otpLogin(Request $request){
        $request->validate([
            'otp' => 'required',
            'user_id' => 'required|exists:users,id'
        ]);
        $userOtp = UserOtp::where('user_id',$request->user_id)->where('otp',$request->otp)->first();
        $now = now();
        if(!$userOtp){
            return redirect()->back()->with('status','Your OTP is not Valid');
        }
        else if($userOtp && $now->isAfter($userOtp->expire_at)){
            return redirect()->back()->with('status','Your OTP has been expired');
        }
        $user = User::whereId($request->user_id)->first();
        if($user){
            $userOtp->update([
                'expire_at'=> now(),
            ]);
            Auth::login($user);
            return redirect('/dashboard');
        }
        return redirect(route('otp-login'))->with('status','Your OTP is not correct');
    }

}
