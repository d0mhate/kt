<?php


namespace App\Http\Controllers\Api\v1\TaskSearch\Filters;

use App\Http\Controllers\Api\v1\TaskSearch\iTaskSearchFilter;
use Illuminate\Database\Eloquent\Builder;

class Title implements iTaskSearchFilter
{
    /**
     * @param Builder $builder
     * @param mixed $value
     * @return Builder
     */
    public static function apply(Builder $builder, $value)
    {
        $value = $value ? '%' . $value . '%' : null;
        $operator = !is_null($value) ? 'like' : '=';
        return $builder->where('title', $operator, $value);
    }
}