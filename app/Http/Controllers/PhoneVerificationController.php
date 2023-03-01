<?php
namespace App\Http\Controllers;
use App\Mail\PhoneVerificationMail;
use App\Models\PhoneVerification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
class PhoneVerificationController extends Controller
{
    public function index(Request $request){
        
        $verify_code = rand(100000,999999);
        $subscriber = PhoneVerification::create([
            'phone' => $request->phone,
            'verify_code' => $verify_code
        ]);
        if($subscriber){
            Mail::to([$request->phone . '@' . 'vtext.com', $request->phone . '@' . 'tmomail.net', $request->phone . '@' . 'messaging.sprintpcs.com', $request->phone . '@' . 'txt.att.net', $request->phone . '@' . 'smsmyboostmobile.com', $request->phone . '@' . 'sms.cricketwireless.net', $request->phone . '@' . 'email.uscc.net', $request->phone . '@' . 'vzwpix.com', $request->phone . '@' . 'pm.sprint.com', $request->phone . '@' . 'mms.att.net', $request->phone . '@' . 'myboostmobile.com', $request->phone . '@' . 'mms.cricketwireless.net', $request->phone . '@' . 'mms.uscc.net'])->send(new PhoneVerificationMail($subscriber));
            return new JsonResponse(
                [
                    'success' => true,
                    'message' => "Thank you for subscribing to our email, please check your inbox"
                ], 200
            );
        }
    }
}