<?php


namespace App\Http\Controllers\Api\v1\UserSearch\Filters;

use App\Http\Controllers\Api\v1\UserSearch\iUserSearchFilter;
use Illuminate\Database\Eloquent\Builder;

class Email implements iUserSearchFilter
{
    /**
     * filter by column email
     * @param Builder $builder
     * @param mixed $value
     * @return Builder
     */
    public static function apply(Builder $builder, $value)
    {
        return $builder->where('email', 'like', '%' . $value . '%');
    }
}