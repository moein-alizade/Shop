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
    return view('client.home');
});


Route::get('adminpanel', function () {
    return view('admin.home');
});



Route::get('/adminpanel/categories', [\App\Http\Controllers\Admin\CategoryController::class, 'index']);
Route::get('/adminpanel/categories/create', [\App\Http\Controllers\Admin\CategoryController::class, 'create']);
Route::post('/adminpanel/categories/store', [\App\Http\Controllers\Admin\CategoryController::class, 'store']);
// {category} = slug
Route::get('/adminpanel/categories/{category}/edit', [\App\Http\Controllers\Admin\CategoryController::class, 'edit']);
Route::patch('/adminpanel/categories/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'update']);
Route::delete('/adminpanel/categories/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy']);

