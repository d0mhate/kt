<?php


namespace App\Http\Controllers\Api\v1\UserSearch\Filters;


use App\Http\Controllers\Api\v1\UserSearch\iUserSearchFilter;
use Illuminate\Database\Eloquent\Builder;

class Name implements iUserSearchFilter
{
    /**
     * @param Builder $builder
     * @param mixed $value
     * @return Builder
     */
    public static function apply(Builder $builder, $value)
    {
        $operator = $value ? 'like' : '=';
        $value = $value ? '%' . $value . '%' : $value;
        return $builder->where('name', $operator, $value);
    }
}