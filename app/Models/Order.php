<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = [
        'order_number', 'user_id', 'first_name', 'last_name', 'email', 'phone',
        'company_name', 'address', 'order_notes', 'shipping_method', 'shipping_address',
        'total_amount', 'order_status', 'payment_status','payment_method', 'order_date'
    ];
    
    protected $casts = [
        'order_date' => 'datetime', // This will ensure that order_date is a Carbon instance
    ];    
    public function items()
{
    return $this->hasMany(OrderItem::class);
}

    public function user()
{
    return $this->belongsTo(User::class, 'user_id', 'id');
}

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function paymentTransaction()
    {
        return $this->hasOne(PaymentTransaction::class, 'order_id');
    }
}
