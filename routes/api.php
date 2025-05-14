<?php

use App\Http\Controllers\Admin\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'v1/auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/captcha', [AuthController::class, 'getCaptcha'])->name('captcha');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
});

Route::prefix('v1')->middleware(['auth:api', \App\Http\Middleware\LogApiRequests::class])->namespace('App\Http\Controllers\Admin')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | 员工 Routes
    |--------------------------------------------------------------------------
    |
    */
    Route::prefix('users')->name('user.')->group(function () {
        Route::get('page', 'UserController@index')->name('index');
        Route::post('/', 'UserController@store')->name('store');
        Route::get('me', 'UserController@me')->name('me');
        Route::get('/{id}/form', 'UserController@show')->name('show')->where('id', '[0-9]+');
        Route::put('/{id}', 'UserController@update')->name('update')->where('id', '[0-9]+');
        Route::delete('/{id}', 'UserController@destroy')->name('delete');
        Route::get('/export', 'UserController@export')->name('export');
        Route::get('/template', 'UserController@template')->name('template');
        Route::post('_import', 'UserController@import')->name('import');
        Route::patch('/{id}/password', 'UserController@resetPassword')->name('resetPassword')->where('id', '[0-9]+');
        Route::patch('/{id}/status', 'UserController@changeStatus')->name('changeStatus')->where('id', '[0-9]+');
        Route::get('/{id}/profile', 'UserController@show')->name('profile')->where('id', '[0-9]+');
        Route::put('/{id}/password/reset', 'UserController@resetPassword')->name('resetPassword')->where('id', '[0-9]+');
        Route::put('/{id}/profile', 'UserController@update')->name('profile.update')->where('id', '[0-9]+');
        Route::get('/profile', 'UserController@me')->name('profile.me');
        Route::put('/profile', 'UserController@updateProfile')->name('updateProfile');
        Route::put('/password', 'UserController@updatePassword')->name('updatePassword');
        Route::get('/options', 'UserController@optionsList')->name('options');

    });

    Route::prefix('dept')->name('dept')->group(function () {
        Route::get('/', 'DeptController@index')->name('index');
        Route::get('/{id}', 'DeptController@show')->name('show')->where('id', '[0-9]+');
        Route::get('/{id}/form', 'DeptController@show')->name('form')->where('id', '[0-9]+');
        Route::post('/', 'DeptController@store')->name('store');
        Route::put('/{id}', 'DeptController@update')->name('update')->where('id', '[0-9]+');
        Route::delete('/{id}', 'DeptController@destroy')->name('delete');
        Route::get('/options', 'DeptController@options')->name('options');
    });

    Route::prefix('menus')->name('menus')->group(function () {
        Route::get('/', 'MenuController@list')->name('list');
        Route::get('/{id}', 'MenuController@show')->name('detail')->where('id', '[0-9]+');
        Route::post('/', 'MenuController@store')->name('store');
        Route::put('/{id}', 'MenuController@update')->name('update')->where('id', '[0-9]+');
        Route::delete('/{id}', 'MenuController@destroy')->name('delete');
        Route::patch('/{id}', 'MenuController@changeStatus')->name('change')->where('id', '[0-9]+');
        Route::get('/{id}/form', 'MenuController@show')->name('show')->where('id', '[0-9]+');
        Route::get('options', 'MenuController@optionsList')->name('optionList');
        Route::get('routes', 'MenuController@routes')->name('routes');
    });

    Route::prefix('logs')->name('logs')->group(function () {
        route::get('/visit-stats', 'LogController@getVisitStats')->name('visit-stats');
        route::get('/visit-trend', 'LogController@getVisitTrend')->name('visit-trend');
    });
    Route::prefix('roles')->name('roles')->group(function () {
        Route::get('/page', 'RoleController@index')->name('index');
        Route::get('/{id}', 'RoleController@show')->name('detail')->where('id', '[0-9]+');
        Route::get('/{id}/form', 'RoleController@show')->name('form')->where('id', '[0-9]+');
        Route::post('/', 'RoleController@store')->name('store');
        Route::put('/{id}', 'RoleController@update')->name('update')->where('id', '[0-9]+');
        Route::delete('/{id}', 'RoleController@destroy')->name('delete');
        Route::patch('/{id}/status', 'RoleController@changeStatus')->name('change')->where('id', '[0-9]+');
        Route::get('options', 'RoleController@optionsList')->name('optionList');
        Route::get('/{id}/menuIds', 'RoleController@menuIds')->name('menuIds')->where('id', '[0-9]+');
        Route::put('/{id}/menus', 'RoleController@storeMenus')->name('menus')->where('id', '[0-9]+');
    });
    Route::prefix('dicts')->name('dicts')->group(function () {
        Route::get('/page', 'DictController@index')->name('index');
        Route::get('/', 'DictController@optionsList')->name('optionsList');
        Route::get('/{id}', 'DictController@show')->name('detail')->where('id', '[0-9]+');
        Route::get('/{id}/form', 'DictController@show')->name('form')->where('id', '[0-9]+');
        Route::post('/', 'DictController@store')->name('store');
        Route::put('/{id}', 'DictController@update')->name('update')->where('id', '[0-9]+');
        Route::delete('/{ids}', 'DictController@destroy')->name('delete');
        Route::patch('/{id}', 'DictController@changeStatus')->name('change')->where('id', '[0-9]+');
        Route::get('options', 'DictController@optionsList')->name('optionList');

        Route::get('/{dictCode}/items/page', 'DictItemController@index')->name('item.index');
        Route::get('/{dictCode}/items', 'DictItemController@show')->name('item.show');
        Route::post('/{dictCode}/items', 'DictItemController@store')->name('item.store');
        Route::get('/{dictCode}/items/{itemId}/form', 'DictItemController@itemShow')->name('item.show');
        Route::put('/{dictCode}/items/{itemId}', 'DictItemController@update')->name('item.update');
        Route::delete('/{dictCode}/items/{itemIds}', 'DictItemController@destroy')->name('item.delete');

    });
    Route::prefix('config')->name('config')->group(function () {
        Route::get('/page', 'ConfigController@index')->name('index');
        Route::get('/{id}/form', 'ConfigController@show')->name('form')->where('id', '[0-9]+');
        Route::get('/{id}', 'ConfigController@show')->name('detail')->where('id', '[0-9]+');
        Route::post('/', 'ConfigController@store')->name('store');
        Route::put('/{id}', 'ConfigController@update')->name('update')->where('id', '[0-9]+');
        Route::delete('/{ids}', 'ConfigController@destroy')->name('delete');
        Route::put('/refresh', 'ConfigController@refresh')->name('refresh');
    });

    Route::prefix('notices')->name('notices')->group(function () {
        Route::get('/my-page', 'UserNoticeController@myNotice')->name('myNotice');
        Route::put('/read-all', 'UserNoticeController@readAll')->name('readAll');
        Route::get('/page', 'NoticeController@index')->name('index');
        Route::get('/{id}/detail', 'NoticeController@show')->name('detail')->where('id', '[0-9]+');
        Route::get('/{id}/form', 'NoticeController@show')->name('form')->where('id', '[0-9]+');
        Route::post('/', 'NoticeController@store')->name('store');
        Route::put('/{id}', 'NoticeController@update')->name('update')->where('id', '[0-9]+');
        Route::delete('/{ids}', 'NoticeController@destroy')->name('delete');
        Route::put('/{id}/publish', 'NoticeController@publish')->name('publish')->where('id', '[0-9]+');
        Route::put('/{id}/revoke', 'NoticeController@revoke')->name('revoke')->where('id', '[0-9]+');
        Route::get('options', 'NoticeController@optionsList')->name('optionList');
    });

    Route::prefix('logs')->name('logs')->group(function () {
        Route::get('/page', 'SysLogController@index')->name('index');
    });
});

