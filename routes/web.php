<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Auth::routes();
Auth::routes(['verify' => true]);

Route::get('/tasks', [App\Http\Controllers\TaskController::class, 'index'])->name('tasks');
Route::get('/tasks/create', [App\Http\Controllers\TaskController::class, 'create'])->name('create_task');
Route::post('/tasks', [App\Http\Controllers\TaskController::class, 'store']);

Route::get('/task_statuses', [App\Http\Controllers\TaskStatusController::class, 'index'])->name('task_statuses');
Route::get('/task_statuses/create', [App\Http\Controllers\TaskStatusController::class, 'create']);
Route::post('/task_statuses', [App\Http\Controllers\TaskStatusController::class, 'store'])->name('store_task_status');
Route::get('/task_statuses/{id}/edit', [App\Http\Controllers\TaskStatusController::class, 'edit']);

Route::get('/labels', [App\Http\Controllers\LabelController::class, 'index'])->name('labels');
Route::post('/labels', [App\Http\Controllers\LabelController::class, 'store']);
Route::get('/labels/create', [App\Http\Controllers\LabelController::class, 'create'])->name('create_label');

Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
