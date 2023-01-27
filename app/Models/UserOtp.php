<?php

namespace App\Models;

use Exception;

use Twilio\Rest\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserOtp extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'otp',
        'expire_at'
    ];
    public function sendSms($receiverNumber){
        $message = 'Login OTP is'.$this->otp;
        try {
            $account_id = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_TOKEN");
            $twilio_number = getenv("TWILIO_FROM");

            $client = new Client($account_id,$auth_token);
            $client->messages->create($receiverNumber,[
                'from' => $twilio_number,
                'body' => $message,
            ]);

            info('OTP Sent Succesfully!');
        } catch(\Exception $e){
            info("Error: ".$e->getMessage());
        }
    }
  
    
}
