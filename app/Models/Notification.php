<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory, SoftDeletes;
    public $fillable = [
        'type',
        'notifiable_type',
        'notifiable_id',
        'data',
    ];

    /**
     * ===========================
     * CONIFG MODEL
     * ===========================
     */
    // protected $dateFormat = 'U';
}
