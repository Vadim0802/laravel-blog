<?php

namespace App\Filters;

use App\Interfaces\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class TagFilter implements FilterInterface
{
    public function __invoke(Builder $query, ?string $value): Builder
    {
        return $query->when($value ?? false, function (Builder $query, string $tag) {
            return $query->whereHas('tags', function ($query) use ($tag) {
                return $query->where('name', $tag);
            });
        });
    }
}
