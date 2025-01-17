<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

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

Route::get('/articles',         [ArticleController::class, 'all']);
Route::get('/articles/{id}',    [ArticleController::class, 'single']);
Route::post('/articles',        [ArticleController::class, 'store']);
Route::get('/duplicate_groups', [ArticleController::class, 'duplicates']);