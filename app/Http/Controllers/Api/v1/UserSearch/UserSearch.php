<?php


namespace App\Http\Controllers\Api\v1\UserSearch;


use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class UserSearch
{
    /**
     * @param Request $filters
     * @return UserResource
     */
    public static function apply(Request $filters)
    {
        $query =
            static::applyDecoratorsFromRequest(
                $filters,
                (new User())->newQuery()
            );
        return static::getResults($query);
    }

    /**
     * @param Request $request
     * @param Builder $query
     * @return Builder
     */
    private static function applyDecoratorsFromRequest(Request $request, Builder $query)
    {
        foreach ($request->all() as $filterName => $value) {
            $decorator = static::createFilterDecorator($filterName);

            if (static::isValidDecorator($decorator)) {
                $query = $decorator::apply($query, $value);
            }
        }
        return $query;
    }

    /**
     * Return filter name
     * @param $name
     * @return string
     */
    private static function createFilterDecorator($name)
    {
        return __NAMESPACE__ . '\\Filters\\' .
            str_replace(
                ' ',
                '',
                ucwords(str_replace('_', ' ', $name))
            );
    }

    /**
     * Check decorator is
     * @param $decorator
     * @return bool
     */
    private static function isValidDecorator($decorator)
    {
        return class_exists($decorator);
    }

    /**
     * Get Results
     * @param Builder $query
     * @return UserResource
     */
    private static function getResults(Builder $query)
    {
        return (new UserResource($query->paginate(UserResource::PAGE_COUNT)));
    }
}