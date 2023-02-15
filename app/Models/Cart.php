<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';
    protected $fillable = [
        'user_id',
        'productsize_id',
        'product_qty',
    ];
    protected $with = ['productsize'];
    public function productsize()
    {
        return $this->belongsTo(ProductSize::class, 'productsize_id', 'id');
    }
}
