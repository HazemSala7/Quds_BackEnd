<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company_id',
        'salesman_id',


    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
