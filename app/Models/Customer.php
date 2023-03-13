<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    public function hasFawater()
    {
        return $this->hasMany(Fawater::class);
    }
    protected $casts = ['id' => 'string'];

    protected $fillable = [
        'id',
        'c_name',
        'c_balance',
        'phone1',
        'last_fatora',
        'last_qabd',
        'salesman_id',
        'address',
        'price_code',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
