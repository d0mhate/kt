<?php


namespace App\Http\Controllers\Api\v1\TaskSearch;


use App\Http\Resources\TaskResource;
use App\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TaskSearch
{
    /**
     * @param Request $filters
     * @return TaskResource
     */
    public static function apply(Request $filters)
    {
        $query =
            static::applyDecoratorsFromRequest(
                $filters,
                (new Task())->newQuery()
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
     * @return TaskResource
     */
    private static function getResults(Builder $query)
    {
        return (new TaskResource($query->paginate(TaskResource::PAGE_COUNT)));
    }

}