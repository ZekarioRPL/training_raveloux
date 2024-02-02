<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class model_has_role extends Model
{
    use HasFactory, SoftDeletes;
    public $fillable = [
        'role_id',
        'model_type',
        'model_id',
    ];
}
