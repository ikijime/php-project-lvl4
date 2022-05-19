<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\TaskStatusController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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

// LOCALE SWITCHER
Route::get('/language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
})->name('language');

Auth::routes(['verify' => true]);
//->middleware('verified') Temporaly disabled
Route::get('/tasks/{id}/edit', [TaskController::class, 'edit']);
Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
Route::resource('tasks', TaskController::class);
Route::get('/tasks/create', [TaskController::class, 'create']);

Route::delete('/task_statuses/{id}', [TaskStatusController::class, 'destroy']);
Route::resource('task_statuses', TaskStatusController::class);

Route::delete('/labels/{id}', [LabelController::class, 'destroy']);
Route::resource('labels', LabelController::class);

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

