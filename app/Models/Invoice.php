<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public $table = 'fawater';
    use HasFactory;

    protected $fillable = [
        'id',
        'f_date',
        'f_value',
        'customer_id',
        'salesman_id',
        'f_discount',
        'store_id',
        'notes',
        'f_time',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
