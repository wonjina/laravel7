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

Route::get('boards', 'Board/BoardController@index');
Route::get('boards/{boardId}/answer', 'Board/QnABoardController@index');

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('boards','Board/BoardController')->except('index');
    Route::resource('boards/{boardId}/answer', 'Board/QnABoardController')->except('index', 'store', 'destroy', 'show');

    Route::middleware('admin')->group(function () {
        Route::post('boards/{boardId}/answer', 'Board/QnABoardController@store');
        Route::delete('boards/{boardId}/answer/{id}', 'Board/QnABoardController@destroy');
    });
});


/**
 * Pdf controller
 */

 // user
 Route::resource('/pdfs', 'Pdf/User/PdfController')->except('index'); //test용
 Route::resource('/users/{id}/services', 'Pdf/User/UserServiceController')->only('index', 'show', 'destroy')->middleware('auth:sanctum');
 Route::resource('/users/{id}/services/{serviceId}/pdfs', 'Pdf/User/UserPdfController')->only('update', 'show')->middleware('auth:sanctum');
 
 //admin
 Route::resource('/services', 'Pdf\Admin\ServiceController');
 Route::resource('/services/{id}/pdfs', 'Pdf\Admin\ServicePdfController');
 Route::resource('/services/{id}/users', 'Pdf\Admin\ServiceUserController');
 Route::resource('/services/{id}/users/{userId}/pdfs', 'Pdf\Admin\ServiceUserPdfController');