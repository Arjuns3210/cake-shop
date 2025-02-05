<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    public function cake()
    {
        return $this->belongsTo(Cake::class, 'cake_id'); // Assuming 'cake_id' is the foreign key in the cart table
    }
}
