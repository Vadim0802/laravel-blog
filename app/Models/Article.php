<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
        return $this->belongsToMany(Tag::class, 'article_tag', 'article_id', 'tag_id');
    }

    public function scopePopular(Builder $query, int $count)
    {
        $query->orderBy('likes_count', 'desc')->limit($count);
    }

    public function scopeFilter(Builder $query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%');
        });

        $query->when($filters['tag'] ?? false, function ($query, $tag) {
            return $query->whereHas('tags', function ($query) use ($tag) {
                return $query->where('name', $tag);
            });
        });
    }
}
