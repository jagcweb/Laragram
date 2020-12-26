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

//use App\Models\Image;

//Generales
Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//UserController
Route::get('/configuracion', [App\Http\Controllers\UserController::class, 'config'])->name('config');
Route::post('/user/edit', [App\Http\Controllers\UserController::class, 'update'])->name('user.edit');
Route::get('/user/avatar/{filename}', [App\Http\Controllers\UserController::class, 'getImage'])->name('user.getimage');
Route::get('/user/{id}/images', [App\Http\Controllers\UserController::class, 'userImages'])->name('user.images');
Route::get('/gente/{search?}', [App\Http\Controllers\UserController::class, 'allUsers'])->name('user.gente');


//ImageController
Route::get('/subir-imagen', [\App\Http\Controllers\ImageController::class, 'create'])->name('image.create');
Route::post('/image/save', [App\Http\Controllers\ImageController::class, 'save'])->name('image.save');
Route::get('/image/{filename}', [App\Http\Controllers\ImageController::class, 'getImage'])->name('image.getimage');
Route::get('/image/delete/{id}', [\App\Http\Controllers\ImageController::class, 'delete'])->name('image.delete');
Route::get('/imagen/edit/{id}', [\App\Http\Controllers\ImageController::class, 'updateForm'])->name('imagen.edit');
Route::post('/image/update/{id}', [App\Http\Controllers\ImageController::class, 'update'])->name('image.update');


//CommentController
Route::get('/imagen/{id}/comments', [App\Http\Controllers\CommentController::class, 'comments'])->name('comments');
Route::post('/comment/save', [App\Http\Controllers\CommentController::class, 'save'])->name('comment.save');
Route::get('/comment/delete/{id}', [App\Http\Controllers\CommentController::class, 'delete'])->name('comment.delete');


//LikeController
Route::get('/like/{image_id}', [App\Http\Controllers\LikeController::class, 'like'])->name('like.save');
Route::get('/dislike/{image_id}', [App\Http\Controllers\LikeController::class, 'dislike'])->name('like.delete');
Route::get('/imagen/{id}/likes', [App\Http\Controllers\LikeController::class, 'imageLikes'])->name('likes');
Route::get('/likes', [App\Http\Controllers\LikeController::class, 'userLikes'])->name('user.likes');


