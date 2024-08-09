<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    // Define the many-to-many relationship with the Product model
    public function products()
    {
        return $this->belongsToMany(Product::class, 'carts_products')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
