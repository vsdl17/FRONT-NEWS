<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthApiController;


Route::get('/login',[AuthApiController::class, 'loginView'])->name('login');
Route::post('/login',[AuthApiController::class, 'login'] )->name('login.submit');
Route::get('/register',[AuthApiController::class, 'registerView'] );
Route::post('/register',[AuthApiController::class, 'register'] )->name('login.register');
Route::post('/logout', function() {
    session()->flush();
    return redirect()->route('login');
})->name('logout');

Route::get('/auth/callback', function() {
    $token = request('token');
    if ($token) {
        session(['token' => $token]);
        return redirect()->route('news.index');
    }
    return redirect()->route('login');
});
Route::get('/news',[AuthApiController::class, 'news'] )->name('news.index');
Route::get('/news/{id}',[AuthApiController::class, 'newsDetail'] )->name('news.detail');

Route::middleware(['jwt.auth'])->group(function() 
{
});

Route::get('/', function () {
    return view('welcome');
});
