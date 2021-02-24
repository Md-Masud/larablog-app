<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\PostController;



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
Route::post('/subscriber', [App\Http\Controllers\SubscriberController::class, 'store'])->name('subscriber.store');


Auth::routes();
Route::group(['as'=>'admin.','prefix'=>'admin','middleware'=>['auth','admin']], function (){
    Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::resource('tag', TagController::class);
    Route::resource('category', CategoriesController::class);
    Route::resource('post',PostController::class);

    Route::put('/post/{id}/approve',[App\Http\Controllers\Admin\PostController::class,'approval'])->name('post.approve');

    Route::get('/subscriber',[App\Http\Controllers\Admin\SubscriberController::class,'index'])->name('subscriber.index');
    Route::delete('/subscriber/{subscriber}',[App\Http\Controllers\Admin\SubscriberController::class,'destroy'])->name('subscriber.destroy');

});

Route::group(['as'=>'author.','prefix'=>'author','middleware'=>['auth','author']], function (){
    Route::get('dashboard',[App\Http\Controllers\Author\DashboardController::class ,'index'])->name('dashboard');
    Route::resource('post',App\Http\Controllers\Author\PostController::class);

});



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
