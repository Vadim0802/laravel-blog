<?php

namespace App\Filters;

use App\Interfaces\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class AuthorFilter implements FilterInterface
{
    public function __invoke(Builder $query, ?string $value): Builder
    {
        return $query->when($value ?? false, function (Builder $query, string $author) {
            $query->whereHas('author', function (Builder $query) use ($author) {
                return $query->where('name', $author);
            });
        });
    }
}
