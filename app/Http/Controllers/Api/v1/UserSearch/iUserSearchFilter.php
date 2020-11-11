<?php


namespace App\Http\Controllers\Api\v1\UserSearch;

use Illuminate\Database\Eloquent\Builder;

interface iUserSearchFilter
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