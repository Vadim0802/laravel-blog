<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'content', 'likes_count', 'slug'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(ArticleComment::class);
    }

    public function likes()
    {
        return $this->hasMany(ArticleLike::class);
    }

    public function scopePopular(Builder $query, int $count)
    {
        return $query->orderBy('likes_count', 'desc')->limit($count);
    }
}
