<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Oauth route
 */

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', function () {
        //auth()->logout();
        Auth::guard('web')->logout();
        return 'sucess';
    });

    Route::middleware('admin')->group(function () {
        Route::get('/admin', function (Request $request) {
            return 'admin sucess';
        });
    });
});

Route::post('/login', function (Request $request) {
    //Log::info('Showing user profile for user: '.$request);
    auth()->attempt($request->only(['email', 'password']));
    return response()->json([
        'auth_user'=>auth()->user()
    ], 200);
});

Route::get('/permission-denied', function () {
    return 'permission-denied';
});



/**
 * Boards route
 */

Route::get('boards', 'BoardController@index');
Route::get('boards/{boardId}/answer', 'QnABoardController@index');

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('boards','BoardController')->except('index');
    Route::resource('boards/{boardId}/answer', 'QnABoardController')->except('index', 'store', 'destroy');

    Route::middleware('admin')->group(function () {
        Route::post('boards/{boardId}/answer', 'QnABoardController@store');
        Route::delete('boards/{boardId}/answer/{id}', 'QnABoardController@destroy');
    });
});

/*
Route::prefix('boards')->middleware('auth:sanctum')->group(function () {   
    Route::resource('{type}', 'BoardController')->except(['index']);
    Route::get('{type}/{id}', 'QnABoardController@index');
    Route::resource('{type}/{id}', 'QnABoardController')->except(['index'])->middleware('admin');
});
*/

/*
Route::prefix('boards')->group(function () {
    Route::get('{type}','BoardController@index');
    Route::resource('{type}', 'BoardController')->except(['index'])->middleware('auth:sanctum');
    
    Route::get('{type}/{id}', 'QnABoardController@index')->middleware('auth:sanctum');;
    Route::resource('{type}/{id}', 'QnABoardController')->except(['index'])->middleware(['auth:sanctum', 'admin']);
});
*/
