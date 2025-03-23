<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    protected $fillable = ['name', 'type', 'phone_number', 'address'];
}
