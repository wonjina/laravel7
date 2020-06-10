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
    if(auth()->user() !== null)
    {
        return response()->json([
            'auth_user'=>auth()->user()
        ], 200);
    } else {
        return response()->json('failed login', 400);
    }
    
});

Route::post('/register', 'Auth\RegisterController@register');
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
    Route::resource('boards/{boardId}/answer', 'QnABoardController')->except('index', 'store', 'destroy', 'show');

    Route::middleware('admin')->group(function () {
        Route::post('boards/{boardId}/answer', 'QnABoardController@store');
        Route::delete('boards/{boardId}/answer/{id}', 'QnABoardController@destroy');
    });
});
