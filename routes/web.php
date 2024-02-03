<?php

use App\Http\Controllers\Asset\OptionController;
use App\Http\Controllers\Auth\AuthController;
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


/**
 * ================
 * AUTH
 * ================
 */
Route::group(['middleware' => 'auth'], function () {

    /**
     * ================
     * DASHBOARD
     * ================
     */
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });
    Route::get('dashboard', function () {
        return view('src.dashboard.index');
    })->name('dashboard');

    /**
     * ================
     * ROUTE
     * ================
     */

    // ROUTE CLIENT
    Route::resource('client', ManageClient::class)->only('index')->middleware('permission:view-client');
    Route::resource('client', ManageClient::class)->only('create', 'store')->middleware('permission:create-client');
    Route::resource('client', ManageClient::class)->only('edit', 'update')->middleware('permission:update-client');
    Route::resource('client', ManageClient::class)->only('destroy')->middleware('permission:delete-client');

    // ROUTE PROJECT
    Route::resource('project', ManageProject::class)->only('index')->middleware('permission:view-project');
    Route::resource('project', ManageProject::class)->only('create', 'store')->middleware('permission:create-project');
    Route::resource('project', ManageProject::class)->only('edit', 'update')->middleware('permission:update-project');
    Route::resource('project', ManageProject::class)->only('destroy')->middleware('permission:delete-project');

    // ROUTE TASK
    Route::resource('task', ManageTask::class)->only('index')->middleware('permission:view-task');
    Route::resource('task', ManageTask::class)->only('create', 'store')->middleware('permission:create-task');
    Route::resource('task', ManageTask::class)->only('edit', 'update')->middleware('permission:update-task');
    Route::resource('task', ManageTask::class)->only('destroy')->middleware('permission:delete-task');

    // ROUTE USER
    Route::resource('user', ManageUser::class)->only('index')->middleware('permission:view-user');
    Route::resource('user', ManageUser::class)->only('create', 'store')->middleware('permission:create-user');
    Route::resource('user', ManageUser::class)->only('edit', 'update')->middleware('permission:update-user');
    Route::resource('user', ManageUser::class)->only('destroy')->middleware('permission:delete-user');
});

/**
 * ================
 * GUEST
 * ================
 */
Route::group(['middleware' => 'guest'], function () {

    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'onLogin'])->name('auth');

    Route::get('/forget-password', function () {
        return view('auth.forgetPassword');
    })->name('forget-password');

    Route::get('/asset/option/client', [OptionController::class, 'client']);
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
