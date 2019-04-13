<?php

namespace App\Http\Controllers;

use App\Model\Rsvp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    private $privateRooms = 2;

    private $sharedSpots = 6;

    private $days = [
        'Nov 1',
        'Nov 2',
        'Nov 3',
        'Nov 4',
        'Nov 5',
        'Nov 6',
        'Nov 7',
        'Nov 8',
        'Nov 9',
        'Nov 10',
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function contribute(Request $request)
    {
        $amount = $request->input('contribution');
        $user = Auth::user();
        $rsvp = $user->rsvp()->getResults();
        $rsvp->has_paid = $amount;
        $rsvp->save();

        return view('index', [
            'user' => Auth::user(),
            'hash' => 'contribute'
        ]);
    }

    public function rsvp(Request $request)
    {
        $rsvpType = $request->input('private') == "true" ? true : false;
        $nights = 0;
        $save = true;
        $days = [];
        $conflicts = [];
        $message = '';
        foreach ($this->days as $count=>$day) {
            $check = $request->input('day'.++$count.'-value');
            $reserve = $check == "true" ? true : false;
            $days[$day] = $reserve;
            if (!$reserve) {
                continue;
            }
            $nights++;
            $available = $this->getAvailability($rsvpType, $day);
            $conflicts[$day]['availability'] = $available;
            if (!$available) {
                $conflicts[$day]['paid'] = $this->getPaid($rsvpType, $day);
                if ($conflicts[$day]['paid']) {
                    $message = "Unfortunately, we don't have $rsvpType space available on your preferred dates :(";
                    $save = false;
                }
            }
        }
        if ($save) {
            $user = Auth::user();
            $rsvp = $user->rsvp()->getResults();
            $rsvp->days = $days;
            $rsvp->nights = $nights;
            $rsvp->private = $rsvpType;
            $rsvp->pet = $request->input('pet') == "true" ? true : false;
            $rsvp->has_rsvp = true;
            $rsvp->save();
        }

        return view('index', [
            'user' => Auth::user(),
            'hasConflicts' => count($conflicts) > 0 ? true : false,
            'conflicts' => $conflicts,
            'hash' => 'rsvp',
            'message' => $message
        ]);
    }

    private function getAvailability($private, $day)
    {
        $rsvps = Rsvp::where('private', $private)->where("days->$day", true)->count();
        if ($private && $rsvps >= $this->privateRooms) {
            return false;
        }
        if (!$private && $rsvps >= $this->sharedSpots) {
            return false;
        }

        return true;
    }

    private function getPaid($private, $day)
    {
        $paid = Rsvp::where('private', $private)
            ->where("days->$day", true)
            ->where("paid", true)
            ->count();

        if ($private && $paid >= $this->privateRooms) {
            return true;
        }

        if (!$private && $paid >= $this->sharedSpots) {
            return true;
        }

        return false;
    }
}
