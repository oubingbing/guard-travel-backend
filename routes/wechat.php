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
use App\Http\Wechat\CollegeArticleController;
use App\Http\Wechat\FollowController;
use App\Http\Wechat\LocationController;
use App\Http\Wechat\NoteCategoryController;
use App\Http\Wechat\NoteController;
use App\Http\Wechat\PraiseController;
use App\Http\Wechat\TravelController;
use App\Http\Wechat\UserController;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    $api->group(['prefix' => 'wechat','middleware' => 'api.throttle', 'limit' => 100, 'expires' => 1], function ($api) {

        $api->group(['prefix' => 'auth'], function ($api) {
            /** 登录 */
            $api->post('/login', LoginController::class . '@apiLogin');
        });

        $api->group(['middleware' => 'wechat'], function ($api) {

            /** 获取用户信息 **/
            $api->get('/user',UserController::class . '@personal');

            /** 获取文章列表 **/
            $api->get("/notes",NoteController::class . "@noteList");

            /** 获取日志列表 **/
            $api->get("/notes",NoteController::class . "@noteList");

            /** 获取文章详情 **/
            $api->get("/note/{id}",NoteController::class . "@detail");

            /** 发送验证码 **/
            $api->post("/send_message",UserController::class . "@sendMessage");

            /** 绑定账号 **/
            $api->post("/bind_user",UserController::class . "@bindUser");

            /** 获得我的笔记分类 **/
            $api->get("/my_categories",NoteCategoryController::class . "@myCategories");

            /** 获取笔记分类的笔记 **/
            $api->get("/category_notes/{id}",NoteController::class . "@getNoteListByCategory");

            /** 点赞 **/
            $api->post("/praise",PraiseController::class . "@praiseNote");

            /** 取消点赞 **/
            $api->post("/cancel_praise",PraiseController::class . "@cancelPraise");

            /** 点赞 **/
            $api->post("/follow",FollowController::class . "@follow");

            /** 取消点赞 **/
            $api->post("/cancel_follow",FollowController::class . "@cancelFollow");
        });

    });

});


