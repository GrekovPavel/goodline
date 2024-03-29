<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', [PostController::class, 'index'])->name('index');;
Route::post('/store', [PostController::class, 'store']);
Route::get('/person', [PostController::class, 'person'])->middleware('auth')->name('person');

require __DIR__.'/auth.php';


Route::get('/{hash}', [PostController::class, 'show']);
