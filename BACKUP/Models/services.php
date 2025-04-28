<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class services extends Model
{
    protected $primaryKey = 'service_id';

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'service_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'service_id');
    }
}
