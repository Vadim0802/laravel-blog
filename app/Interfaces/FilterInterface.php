<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface FilterInterface
{
    public function __invoke(Builder $query, ?string $value): Builder;
}
