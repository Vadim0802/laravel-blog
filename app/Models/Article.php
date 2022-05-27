<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string title
 * @property string content
 * @property integer likes_count
 * @property string slug
 */
class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'content', 'likes_count', 'slug'
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(ArticleComment::class);
    }

    public function likes()
    {
        return $this->hasMany(ArticleLike::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
