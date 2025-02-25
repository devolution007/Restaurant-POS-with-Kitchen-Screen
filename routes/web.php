<?php

use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Route;

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

Route::get('/opt', function () {
    \Artisan::call('migrate:fresh --seed');
    dd(\Artisan::output());
});

Route::get('{all}', [AppController::class, 'index'])
    ->where('all', '^((?!api).)*')
    ->name('index');
