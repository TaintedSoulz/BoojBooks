<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/books', [App\Http\Controllers\BooksController::class, 'show'])->name('books.show');
Route::post('/books', [App\Http\Controllers\BooksController::class, 'store'])->name('books.store');
Route::get('/books/{id}/destroy', [App\Http\Controllers\BooksController::class, 'destroy'])->name('books.destroy');


Auth::routes();
