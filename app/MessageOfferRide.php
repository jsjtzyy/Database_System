<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageOfferRide extends Model
{
    protected $fillable = [
        'category',
        'content',
        'date',
        'time',
        'destination',
        'curLocation',
        'seatsNumber',
        'userID'
    ];
}
