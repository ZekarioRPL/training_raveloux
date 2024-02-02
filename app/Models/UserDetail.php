<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDetail extends Model
{
    use HasFactory, SoftDeletes;
    public $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'address',
        'phone_number',
    ];
}
