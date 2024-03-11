<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id', 'id');
    }
    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id', 'id');
    }
}
