<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'user_id',
        'block_number',
        'house_number',
        'street_name',
        'adiitional_info',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
