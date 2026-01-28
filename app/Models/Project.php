<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'status',
        'github_url',
        'demo_url',
        'date_realisation',
        'author_id',
        'is_featured',
        'order',
    ];

    protected $casts = [
        'date_realisation' => 'date',
        'is_featured' => 'boolean',
    ];

    // Relations
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function technologies()
    {
        return $this->belongsToMany(Technology::class, 'project_technology');
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
