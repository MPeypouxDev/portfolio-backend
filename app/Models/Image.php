<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'path',
        'alt_text',
        'is_primary',
        'order',
        'project_id',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    // Relations
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}