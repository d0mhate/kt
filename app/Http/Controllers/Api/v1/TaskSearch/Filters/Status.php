<?php


namespace App\Http\Controllers\Api\v1\TaskSearch\Filters;


use App\Http\Controllers\Api\v1\TaskSearch\iTaskSearchFilter;
use Illuminate\Database\Eloquent\Builder;

class Status implements iTaskSearchFilter
{
    /**
     * @param Builder $builder
     * @param mixed $value
     * @return Builder
     */
    public static function apply(Builder $builder, $value)
    {
        return $builder->where('status', $value);
    }
}