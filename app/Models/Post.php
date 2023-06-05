<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'preview_image',
        'detail_image',
        'user_id',
        'active',
        'sort'
    ];

    protected $casts = [
        'active' => 'integer'
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', 1);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
