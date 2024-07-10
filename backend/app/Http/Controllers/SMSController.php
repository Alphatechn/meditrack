<?php

namespace App\Http\Controllers;

use App\Services\OrangeSMSService;
use Illuminate\Http\Request;

class SMSController extends Controller
{
    protected $smsService;

    public function __construct(OrangeSMSService $smsService)
    {
        $this->smsService = $smsService;
    }

    public function send(Request $request)
    {
        // $request->validate([
        //     'recipient' => 'required|regex:/^[0-9]{9}$/',
        //     'message' => 'required|string|max:160'
        // ]);

        $recipient = '651134833';
        $message = 'hello';

        $response = $this->smsService->sendSMS($recipient, $message);

        return response()->json($response);
    }
}
