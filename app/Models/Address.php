<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Malhal\Geographical\Geographical;

class Address extends Model
{
    use HasFactory, Geographical;

    protected static $kilometers = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getNearLocation($latitude, $longitude)
    {
        return Address::where('workplace', true)->
        geofence($latitude, $longitude, 0, config('setup.DEFAULT_RADIUS'))->
        orderBy('distance', 'ASC')->get();
    }
}
