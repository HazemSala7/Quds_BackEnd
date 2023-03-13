<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prices extends Model
{
    public $table = 'prices';
    use HasFactory;
    // public function Products()
    // {
    //     return $this->hasMany(Product::class);
    // }
    function product()
    {
        return $this->belongsTo(Product::class);
    }
    protected $fillable = [
        'id',
        'product_id',
        'price_code',
        'price'

    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
