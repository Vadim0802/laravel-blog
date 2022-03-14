<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface FilterInterface
{
    public function filter(Builder $query, string|null $value): Builder;
}
