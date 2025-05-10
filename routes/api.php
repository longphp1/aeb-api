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

Route::prefix('v1')->middleware(['auth:api'])->namespace('App\Http\Controllers\Admin')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | 员工 Routes
    |--------------------------------------------------------------------------
    |
    */
    Route::prefix('users')->name('user.')->group(function () {
        Route::get('page', 'UserController@index')->name('index');
        Route::get('me', 'UserController@me')->name('me');
        Route::get('/{id}/form', 'UserController@show')->name('show')->where('id', '[0-9]+');
        Route::post('/', 'UserController@store')->name('store');
        Route::put('/{id}', 'UserController@update')->name('update')->where('id', '[0-9]+');
        Route::delete('/{id}', 'UserController@show')->name('delete')->where('id', '[0-9]+');
        Route::get('/export', 'UserController@export')->name('export');
    });

    Route::prefix('dept')->name('dept')->group(function () {
        Route::get('/', 'DeptController@index')->name('index');
        Route::get('/{id}', 'DeptController@show')->name('show')->where('id', '[0-9]+');
        Route::get('/{id}/form', 'DeptController@show')->name('show')->where('id', '[0-9]+');
        Route::post('/', 'DeptController@store')->name('store');
        Route::put('/{id}', 'DeptController@update')->name('update')->where('id', '[0-9]+');
        Route::delete('/{id}', 'DeptController@destroy')->name('delete')->where('id', '[0-9]+');
        Route::get('/options', 'DeptController@options')->name('options');
    });

    Route::prefix('menus')->name('menus')->group(function () {
        Route::get('/', 'MenuController@list')->name('list');
        Route::get('/{id}', 'MenuController@show')->name('detail')->where('id', '[0-9]+');
        Route::post('/', 'MenuController@store')->name('store');
        Route::put('/{id}', 'MenuController@update')->name('update')->where('id', '[0-9]+');
        Route::delete('/{id}', 'MenuController@destroy')->name('delete')->where('id', '[0-9]+');
        Route::patch('/{id}', 'MenuController@changeStatus')->name('change')->where('id', '[0-9]+');
        Route::get('/{id}/form', 'MenuController@show')->name('show')->where('id', '[0-9]+');
        Route::get('options', 'MenuController@optionsList')->name('optionList');
        Route::get('routes', 'MenuController@routes')->name('routes');

    });
    Route::prefix('notices')->name('notices')->group(function () {
        Route::get('/my-page', 'UserNoticeController@myNotice')->name('myNotice');
    });
    Route::prefix('logs')->name('logs')->group(function () {
        route::get('/visit-stats', 'LogController@getVisitStats')->name('visit-stats');
        route::get('/visit-trend', 'LogController@getVisitTrend')->name('visit-trend');
    });
    Route::prefix('roles')->name('roles')->group(function () {
        Route::get('/', 'RoleController@index')->name('index');
        Route::get('/{id}', 'RoleController@show')->name('detail')->where('id', '[0-9]+');
        Route::post('/', 'RoleController@store')->name('store');
        Route::put('/{id}', 'RoleController@update')->name('update')->where('id', '[0-9]+');
        Route::delete('/{id}', 'RoleController@destroy')->name('delete')->where('id', '[0-9]+');
        Route::patch('/{id}', 'RoleController@changeStatus')->name('change')->where('id', '[0-9]+');
        Route::get('options', 'RoleController@optionsList')->name('optionList');
    });
    Route::prefix('dicts')->name('dicts')->group(function () {
        Route::get('/', 'DictController@index')->name('index');
        Route::get('/{id}', 'DictController@show')->name('detail')->where('id', '[0-9]+');
        Route::post('/', 'DictController@store')->name('store');
        Route::put('/{id}', 'DictController@update')->name('update')->where('id', '[0-9]+');
        Route::delete('/{id}', 'DictController@destroy')->name('delete')->where('id', '[0-9]+');
        Route::patch('/{id}', 'DictController@changeStatus')->name('change')->where('id', '[0-9]+');
        Route::get('options', 'DictController@optionsList')->name('optionList');
        Route::get('/{id}/items', 'DictController@getDictItems')->name('getDictItems')->where('id', '[0-9]+');
    });
});

