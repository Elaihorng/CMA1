<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'booking'; // 👈 tell Laravel to use the singular table name

    protected $fillable = [
        'user_id', 'name', 'service_date', 'email', 'request','status'
    ];
}
