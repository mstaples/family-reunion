<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Rsvp extends Model
{
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
}
