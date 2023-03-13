<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account_Statement extends Model
{
    public $table = 'kashf_hesab';
    use HasFactory;

    protected $fillable = [
        'id',
        'customer_id',
        'money_amount',
        'action_type',
        'action_id',
        'action_date',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
