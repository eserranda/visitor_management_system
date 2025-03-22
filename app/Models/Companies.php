<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    protected $fillable = ['full_name', 'visitor_type', 'phone_number', 'company_id']; // Menambahkan company_id
}
