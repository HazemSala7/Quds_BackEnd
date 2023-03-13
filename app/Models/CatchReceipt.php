<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatchReceipt extends Model
{
    public $table = 'qabds';
    use HasFactory;

    protected $fillable = [
        'id',
        'cash',
        'discount',
        'customer_id',
        'company_id',
        'salesman_id',
        'chks',
        'store_id',
        'notes',
        'q_date',
        'q_time',
        'downloaded',
        'q_type',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
