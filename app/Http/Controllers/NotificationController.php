<?php

namespace App\Http\Controllers;

use App\Model\Rsvp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function notification(Request $request)
    {
        $user = Auth::user();
        $notification = $user->notification()->getResults();
        $notification->contribution_email = $request->input('contribution_email');
        $notification->contribution_text = $request->input('contribution_text');
        $notification->preparation_email = $request->input('preparation_email');
        $notification->preparation_text = $request->input('preparation_text');
        $notification->save();

        return view('index', [
            'user' => Auth::user(),
            'hash' => 'notification'
        ]);
    }
}
