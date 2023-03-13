<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catches extends Model
{
    public $table = 'qabds';
    use HasFactory;
    function product()
    {
        return $this->belongsTo(Product::class);
    }
    function Customer()
    {
        return $this->belongsTo(Customer::class);
    }
    protected $fillable = [
        'store_id',
        'customer_id',
        'cash',
        'discount',
        'chks',
        'notes',
        'q_date',
        'q_time',
        'salesman_id',
        'company_id',
        'q_type',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
