<?php


namespace App\Http\Controllers\Api\v1\TaskSearch;

use Illuminate\Database\Eloquent\Builder;

interface iTaskSearchFilter
{
    /**
     * Apply a given search value to the builder instance.
     *
     * @param Builder $builder
     * @param mixed $value
     * @return Builder $builder
     */
    public static function apply(Builder $builder, $value);
}