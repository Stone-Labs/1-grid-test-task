<?php

use App\Http\Controllers\PostController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::prefix('blog')->middleware(['auth'])->group(function (){
    Route::get('/', [PostController::class, 'index'])->name('blog.index');
    Route::get('/create', [PostController::class, 'create'])->name('blog.create');
    Route::post('/', [PostController::class, 'store'])->name('blog.store');
    Route::get('/{slug}', [PostController::class, 'show'])->name('blog.show');
    Route::get('/{id}/edit', [PostController::class, 'edit'])->name('blog.edit');
    Route::patch('/{id}', [PostController::class, 'update'])->name('blog.update');
    Route::delete('/{id}', [PostController::class, 'destroy'])->name('blog.destroy');
});

require __DIR__.'/auth.php';
