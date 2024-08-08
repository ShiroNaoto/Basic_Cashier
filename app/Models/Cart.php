<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['prodid','price', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'prodid');
    }
}
