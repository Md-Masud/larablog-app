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

Auth::routes();
Route::group(['as'=>'admin.','prefix'=>'admin','middleware'=>['auth','admin']], function (){
    Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::resource('tag', TagController::class);
    Route::resource('category', CategoriesController::class);
    Route::resource('post',PostController::class);

});

Route::group(['as'=>'author.','prefix'=>'author','namespace'=>'Author','middleware'=>['auth','author']], function (){
    Route::get('dashboard',[App\Http\Controllers\Author\DashboardController::class ,'index'])->name('dashboard');

});




Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
