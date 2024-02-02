<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;
    public $fillable = [
        'name',
        'guard_name'
    ];

    // /**
    //  * ===========================
    //  * CONIFG MODEL
    //  * ===========================
    //  */
    // protected $dateFormat = 'U';
}
