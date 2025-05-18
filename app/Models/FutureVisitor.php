<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FutureVisitor extends Model
{
    protected $fillable = [
        'user_id',
        'address_id',
        'visitor_name',
        'arrival_date',
        'estimated_arrival_time',
        'vehicle_number',
        'vehicle_type',
        'status',
        'check_in',
        'check_out',
        'img_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
