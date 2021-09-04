<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Models\Book;
use Illuminate\Support\Facades\Redirect;
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

Route::redirect('/', 'books');

Route::resource('books', Bookcontroller::class);

Route::resource('authors', AuthorController::class);

Route::get('/authors.index/delete_author_{id}', [AuthorController::class, 'destroy'])->name('delete_author');

Route::post('/books.index/book_form_edit/update_book_{id}', [BookController::class, 'update'])->name('update_book');

Route::get('/books.index/delete_book_{id}', [BookController::class, 'destroy'])->name('delete_book');
