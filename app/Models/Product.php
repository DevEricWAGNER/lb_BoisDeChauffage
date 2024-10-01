<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'product_name', 'photo', 'price', 'product_description'];

    // Define the many-to-many relationship with the Cart model
    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'carts_products')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}
