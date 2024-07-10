<?php

namespace App\Http\Controllers;

use App\Helpers\Sms;
use Illuminate\Http\Request;

class MessageController extends Controller
{

    public function create()
    {
        $title = 'Nouveau message';

        return view('backend.messages.create', compact(['title']));
    }

    public function send(Request $request)
    {
        // $this->validate($request, [
        //     'phone' => 'required|numeric',
        //     'message' => 'required|max:255',
        // ]);

        $this->sendSMS('51138433', 'hello gyusuusus');

        // return redirect(route('message.create'));
    }

    public function sendSMS($phone, $message)
    {
        $config = array(
            'clientId' => getenv('CLIENT_ID'),
            'clientSecret' =>  getenv('CLIENT_SECRET'),
        );

        $osms = new Sms($config);

        // $data = $osms->getTokenFromConsumerKey();
        // $token = array(
        //     'token' => $data['access_token']
        // );

        $response = $osms->sendSms(
            // sender
            'tel:+23794979861',
            // receiver
            'tel:+237' . $phone,
            // message
            $message,
            'Devscom'
        );

        return $response;
    }
}
