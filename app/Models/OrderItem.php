<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items'; // Table name

    protected $fillable = [
        'order_id',
        'cake_id',
        'quantity',
        'payment_amount',
    ];

    /**
     * Relationship with Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relationship with Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function cake()
{
    return $this->belongsTo(Cake::class, 'cake_id'); // Ensure 'cake_id' correctly maps to 'products.id'
}

}
