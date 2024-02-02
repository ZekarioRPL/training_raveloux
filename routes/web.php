<?php

use App\Http\Controllers\Asset\OptionController;
use App\Http\Controllers\Client\ManageClient;
use App\Http\Controllers\Project\ManageProject;
use App\Http\Controllers\Task\ManageTask;
use App\Http\Controllers\User\ManageUser;
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
Route::resource('project', ManageProject::class);
Route::resource('task', ManageTask::class);
Route::resource('user', ManageUser::class);

Route::group(['middleware' => 'auth'], function () {
    Route::get('home', function () {
        return view('src.home.index');
    })->name('home');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
    Route::get('/forget-password', function () {
        return view('auth.forgetPassword');
    })->name('forget-password');
    // Route::post('/auth', [AuthController::class, 'actionLogin'])->name('auth');

    Route::get('/asset/option/client', [OptionController::class, 'client']);
});
