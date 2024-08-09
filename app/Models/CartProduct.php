<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    use HasFactory;

    protected $table = 'carts_products'; // Specify the table name

    protected $fillable = ['cart_id', 'product_id', 'quantity']; // Specify fillable fields
}
