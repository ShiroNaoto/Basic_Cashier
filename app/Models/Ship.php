<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ship extends Model
{
    use HasFactory;

    protected $fillable = ['prodid', 'price', 'quantity', 'payment_method'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'prodid');
    }
}
