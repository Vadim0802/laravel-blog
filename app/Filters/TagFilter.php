<?php

namespace App\Filters;

use App\Interfaces\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class TagFilter implements FilterInterface
{
    public function filter(Builder $query, string|null $value): Builder
    {
        return $query->when($value ?? false, function ($query, $tag) {
            return $query->whereHas('tags', function ($query) use ($tag) {
                return $query->where('name', $tag);
            });
        });
    }
}
