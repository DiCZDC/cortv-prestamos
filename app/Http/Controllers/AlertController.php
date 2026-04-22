<?php

namespace App\Http\Controllers;

use App\Notifications\alert;

class AlertController extends Controller
{
    //
    public function send_alert()
    {
        $user = auth()->user();
        $user->notify(new alert);

        return response()->json(['message' => 'Alerta enviada']);
    }
}
