<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Rsvp extends Model
{
    private $privateCostPerNight = 160;

    private $sharedCostPerNight = 70;

    private $petCostPerNight = 60;

    protected $casts = [
        'days' => 'array'
    ];

    protected $fillable = [ 'days' ];

    public function __construct(array $attributes = []) {
        parent::__construct($attributes + ['days' => [
                'Nov 1' => false,
                'Nov 2' => false,
                'Nov 3' => false,
                'Nov 4' => false,
                'Nov 5' => false,
                'Nov 6' => false,
                'Nov 7' => false,
                'Nov 8' => false,
                'Nov 9' => false,
                'Nov 10' => false,
            ]]);
    }

    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }

    public function setHasPaid($amount)
    {
        $this->has_paid = $amount;
        if ($amount > $this->getSplit()) {
            $this->paid = true;
        }
    }

    public function getContributionMessage()
    {
        $message = "";
        $split = $this->getSplit();
        if ($this->has_paid > $split) {
            $this->paid = true;
            $remainder = $this->has_paid - $split;
            $shared = floor($remainder / $this->sharedCostPerNight);
            $private = floor($remainder / $this->privateCostPerNight);

            if ($shared > 0 && $private > 0) {
                $privateText = $private > 1 ? "$private nights" : "1 night";
                $message = "You've paid for your split of the housing costs plus contributed enough to cover someone else for $shared nights in a shared space or $privateText in a private room. Thank you so much for your generosity!";
            } elseif ($shared > 0) {
                $message = "You've paid for your split of the housing costs plus contributed enough to cover someone else for $shared night in a shared space. Thank you so much for your generosity!";
            } else {
                $message = "You've paid for your split of the housing costs. Thank you!";
            }
        }
        
        return $message;
    }

    public function getSplit()
    {
        $per = $this->private ? $this->privateCostPerNight : $this->sharedCostPerNight;

        $per = $this->pet ? $per + $this->petCostPerNight : $per;

        $total = $per * $this->nights;

        return $total;
    }
}
