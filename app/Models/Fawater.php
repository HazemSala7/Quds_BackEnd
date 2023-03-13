<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Fawater extends Model
{
    public $table = 'fawater';
    use HasFactory;
    function customers()
    {
        return $this->belongsTo(Customer::class);
    }
    function product()
    {
        return $this->belongsTo(InvoiceProduct::class);
    }
    protected $fillable = [
        'f_date',
        'f_value',
        'customer_id',
        'salesman_id',
        'f_discount',
        'store_id',
        'f_time',
        'notes',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
