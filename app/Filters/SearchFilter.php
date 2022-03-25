<?php

namespace App\Filters;

use App\Interfaces\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class SearchFilter implements FilterInterface
{
    public function __invoke(Builder $query, ?string $value): Builder
    {
        return $query->when($value ?? false, function (Builder $query, string $search) {
            return $query->where('title', 'like', '%' . $search . '%');
        });
    }
}
