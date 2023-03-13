<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FatoraProduct extends Model
{
    public $table = 'fatora_products';
    use HasFactory;
    function customers()
    {
        return $this->belongsTo(Customer::class);
    }
    function product()
    {
        return $this->belongsTo(Product::class);
    }
    protected $fillable = [
        'fatora_id',
        'product_id',
        'customer_id',
        'p_quantity',
        'p_price',
        'bonus1',
        'bonus2',
        'discount',
        'notes',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
