<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class role_has_permission extends Model
{
    use HasFactory, SoftDeletes;
    public $fillable = [
        'permission_id',
        'role_id',
    ];
}
