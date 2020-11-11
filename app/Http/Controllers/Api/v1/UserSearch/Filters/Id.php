<?php


namespace App\Http\Controllers\Api\v1\UserSearch\Filters;


use App\Http\Controllers\Api\v1\UserSearch\iUserSearchFilter;
use Illuminate\Database\Eloquent\Builder;

class Id implements iUserSearchFilter
{
    /**
     * just do it
     * @param Builder $builder
     * @param mixed $value
     * @return Builder|void
     */
    public static function apply(Builder $builder, $value)
    {
        $builder->where('id', $value);
        //todo eat array
    }
}