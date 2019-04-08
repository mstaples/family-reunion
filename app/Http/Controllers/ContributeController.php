<?php

namespace App\Http\Controllers;

use App\Model\Rsvp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContributeController extends Controller
{
    private $privateCostPerNight = 146;

    private $sharedCostPerNight = 75;

    private $petCostPerNight = 75;

    public function __construct()
    {
        $this->middleware('auth');
    }

    private function getCost($private, $pet, $nights)
    {
        $per = $private ? $this->privateCostPerNight : $this->sharedCostPerNight;

        $per = $pet ? $per + $this->petCostPerNight : $per;

        $total = $per * $nights;

        return $total;
    }
}
