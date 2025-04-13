<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FutureVisitor extends Model
{
    protected $fillable = [
        'user_id',
        'visitor_name',
        'arrival_date',
        'estimated_arrival_time',
        'vehicle_number'
    ];

    protected $casts = [
        'arrival_date' => 'date',
        'estimated_arrival_time' => 'time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
