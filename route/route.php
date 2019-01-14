<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

Route::get('hello/:name', 'index/hello');
//Route::get('api/:version/index', 'api/:version.Index/index');

Route::post('api/:version/token/admin', 'api/:version.Token/getAdminToken');
Route::post('api/:version/token/user', 'api/:version.Token/getUserToken');

Route::post('api/:version/order/save', 'api/:version.Order/save');
Route::get('api/:version/order/push/info', 'api/:version.Order/getPush');
Route::post('api/:version/select/user', 'api/:version.Order/selectUser');
Route::get('api/:version/select/receive', 'api/:version.Order/receiveSelect');
