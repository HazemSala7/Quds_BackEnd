<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceProduct extends Model
{
    public $table = 'fatora_products';
    use HasFactory;
    function product()
    {
        return $this->belongsTo(Product::class);
    }
    protected $fillable = [
        'id',
        'fatora_id',
        'product_id',
        'p_quantity',
        'p_price',
        'store_id',
        'bonus1',
        'bonus2',
        'discount',
        'notes',
        'total',
        'active',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
