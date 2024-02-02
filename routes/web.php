<?php

use App\Http\Controllers\Client\ManageClient;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('dashboard', function () {
    return view('src.dashboard.index');
});

Route::resource('client', ManageClient::class);

Route::group(['middleware' => 'auth'], function () {
    Route::get('home', function () {
        return view('src.home.index');
    })->name('home');
});

Route::group(['middleware' => 'guest'], function () {
    // Route::get('/login', [AuthController::class, 'login'])->name('login');
    // Route::post('/auth', [AuthController::class, 'actionLogin'])->name('auth');
});