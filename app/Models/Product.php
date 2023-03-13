<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    function product()
    {
        return $this->hasMany(Prices::class);
    }
    protected $casts = ['id' => 'string'];
    
    protected $fillable = [
        'p_name',
        'product_barcode',
        'quantity',
        'img_path',

    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
