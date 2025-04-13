<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitors extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'visitor_type',
        'company_id',
        'phone_number',
        'vehicle_number',
        'purpose',
        'check_in',
        'check_out',
        'img_url',
        'status',
        'information',
        'captured_image'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Companies::class);
    }
}
