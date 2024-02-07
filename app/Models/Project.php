<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class Project extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;
    public $fillable = [
        'title',
        'description',
        'user_id',
        'client_id',
        'deadline',
        'status'
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('project_media')
            ->onlyKeepLatest(8);
    }

    /**
     * ===========================
     * CONIFG MODEL
     * ===========================
     */
    // protected $dateFormat = 'U';
}
