<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Notification extends Model
{
    public $options = [ "none", "weekly", "twice-monthly", "monthly", "once" ];

    protected $fillable = [
        'last_contribution_email',
        'last_contribution_text',
        'last_preparation_email',
        'last_preparation_text'
    ];

    public function __construct(array $attributes = []) {
        parent::__construct($attributes + [
                'last_contribution_email' => Carbon::now()->subDays(14),
                'last_contribution_text' => Carbon::now()->subDays(14),
                'last_preparation_email' => Carbon::now()->subDays(14),
                'last_preparation_text' => Carbon::now()->subDays(14)
            ]);
    }

    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }

}
