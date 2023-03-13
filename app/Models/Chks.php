<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chks extends Model
{
    public $table = 'chks';
    use HasFactory;

    protected $fillable = [
        'qabd_id',
        'chk_no',
        'chk_value',
        'chk_date',
        'account_no',
        'bank_no',
        'bank_branch',
        'company_id',
        'q_type',

    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
