<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\Auth\LoginController;
use App\Http\Wechat\LocationController;
use App\Http\Wechat\TravelController;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    $api->group(['prefix' => 'wechat','middleware' => 'api.throttle', 'limit' => 100, 'expires' => 1], function ($api) {

        $api->group(['prefix' => 'auth', 'middleware' => 'before'], function ($api) {
            /** 登录 */
            $api->post('/login', LoginController::class . '@apiLogin');
        });

        $api->group(['middleware' => 'wechat'], function ($api) {
            /** 登录 */
            $api->post('/location', LocationController::class . '@saveLocation');

            /** 创建旅途 */
            $api->post('/plan',TravelController::class . '@createTravelPlan');

            /** 获取旅途 */
            $api->get('/plan',TravelController::class . '@userPlan');
        });

    });

});


