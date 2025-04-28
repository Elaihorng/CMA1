<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment_transactions extends Model
{
    protected $primaryKey = 'payment_id';

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
