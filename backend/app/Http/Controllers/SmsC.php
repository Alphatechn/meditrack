<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class SmsC extends Controller
{
    public function sendsms()
    {
        $sid = getenv("TWILIO_SID");
        $token = getenv("TWILIO_TOKEN");
        $sendernumber = getenv("TWILIO_PHONE");
        $twilio = new Client($sid, $token);
        $message = $twilio->messages
            ->create(
                "+237670938819",
                [
                    "body" => "Bonjour mon nom c'est Alphred Bienvenue dans MEDITRACK",
                    "from" =>$sendernumber
                ]
            );
        dd("message envoye avec succes");
    }
}
