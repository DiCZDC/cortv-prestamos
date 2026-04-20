<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\alert;
class AlertController extends Controller
{
    //
    public function send_alert()
    {
        $user = auth()->user();
        $user->notify(new \App\Notifications\alert());

        return response()->json(['message' => 'Alerta enviada']);
    }
}
