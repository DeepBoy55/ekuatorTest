<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\productsController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', 'App\Http\Controllers\userController@store');
Route::post('/login', 'App\Http\Controllers\userController@login');
Route::post('/logout', 'App\Http\Controllers\userController@logout');


//products
Route::get('/products-list', 'App\Http\Controllers\productsController@index');
Route::post('/upload-products', 'App\Http\Controllers\productsController@store');
Route::post('/update-products/{id}', 'App\Http\Controllers\productsController@update');
Route::get('/products-detail/{id}', 'App\Http\Controllers\productsController@show');
Route::post('/remove-product/{id}', 'App\Http\Controllers\productsController@destroy');

Route::post('transactions', 'App\Http\Controllers\TransactionController@store');
Route::get('/Admin-transaction', 'App\Http\Controllers\TransactionController@showAdmin');
Route::post('/History-Transactions', 'App\Http\Controllers\TransactionController@scopeOwnedByUser');
Route::get('/Detail-Admin-transaction/{id}', 'App\Http\Controllers\TransactionController@detailTransactionAdmin');
Route::post('/Detail-Transactions/{id}', 'App\Http\Controllers\TransactionController@detailHistoryUser');

