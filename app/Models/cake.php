<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cake extends Model
{
    use HasFactory;

    protected $casts = [
        'cake_price' => 'integer',
    ];

    public function category(){

        // return $this->belongsTo('app\Models\Category');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'cake_id'); // Assuming 'cake_id' is the foreign key in the cart table
    }
}
