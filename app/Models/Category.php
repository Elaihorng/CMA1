<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category'; 
    public $timestamps = false; 
    protected $fillable = ['name']; // Allow mass assignment on 'name'

    public function products()
    {
        return $this->hasMany(Product::class);
    }


}
