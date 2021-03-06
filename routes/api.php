<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get(
    '/user',
    function (Request $request) {
        return $request->user();
    }
);

//Route::group([
//    'prefix' => 'v1',
//    'namespace' => 'Api\v1',
//], function () {
//    Route::group([
//        'middleware' => ['auth:api']
//    ],function(){
//        //Tasks
//        Route::apiResource('/task', 'TasksApiController');
//    });
//});

Route::group(
    [
        'namespace' => 'Api\v1'
    ],
    function () {
        //register
        Route::post('register', 'UsersApiController@store');

        Route::group(
            [
                'middleware' => ['auth:api']
            ],
            function () {
                Route::post('/task/filter', 'SearchApiController@taskFilter');
                Route::post('/user/filter', 'SearchApiController@userFilter');
                Route::apiResource('/task', 'TasksApiController');
                Route::apiResource('/user', 'UsersApiController');
            }
        );
    }
);